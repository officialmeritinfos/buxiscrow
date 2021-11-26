<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Custom\FlutterWave;
use App\Custom\RandomString;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\Charges;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\MerchantPayouts as transfers;
use App\Models\Transactions;
use App\Models\UserBalances;
use App\Models\UserBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Payouts extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $transfers = transfers::where('merchant',$user->id)->get();
        $currencies = CurrencyAccepted::where('status',1)->get();
        $banks = AcceptedBanks::where('status',1)->get();
        $beneficiaries = UserBeneficiary::where('user',$user->id)->where('status',1)->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Transfers', 'slogan' => '- Making safer transactions',
            'user' => $user,'transfers'=>$transfers,'currencies'=>$currencies,'banks'=>$banks,'beneficiaries'=>$beneficiaries];
        return view('dashboard.merchant.payouts', $dataView);
    }
    public function getBeneficiaryId($id){
        $user = Auth::user();
        $bene = UserBeneficiary::where('user',$user->id)->where('id',$id)->first();
        if (!empty($bene)){
            $success['fetched']=true;
            $success['bank']=$bene->bank;
            $success['account_number']=$bene->accountNumber;
            $success['account_name']=$bene->accountName;
            $success['bank_code']=$bene->bankCode;
            $success['ben_id']=$bene->beneficiaryId;
            return $this->sendResponse($success, 'Account Fetched');
        }else{
            return $this->sendError('Invalid Request',['error'=>'No data found'],'422','Validation Failed');
        }
    }
    public function authenticateTransfer(Request $request){
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            ['account_credit'=>['required','numeric','integer'],],
            ['required'  =>':attribute is required'],
            ['account_credit'   =>'Account to Credit']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422',
                'Validation Failed');
        }
        $user = Auth::user();
        //check if user can transfer money
        if ($user->canSend !=1){
            $this->sendError('Transfer Error',['error'=>'Your account is currently deactivated and therefore cannot
            send out money. Please contact support for more information.'],'422',
                'Validation Failed');
        }
        switch ($request->input('account_credit')){
            case 2:
                $data = $this->authenticateTransferFromBeneficiary($request,$user);

                break;
            default:
                $data = $this->sendError('Error validation',['error'=>'Please add your desired account as a beneficiary
                first.'],'422',
                    'Validation Failed');
                break;
        }
        return $data;
    }
    public function authenticateTransferFromBeneficiary($request,$user){
        $validator = Validator::make($request->all(),
            [
                'ben_id'=>['required','numeric'],
                'pin'=>['required','numeric'],
                'amount'=>['required','numeric'],
                'currency'=>['required','alpha',Rule::in(['NGN','USD']) ],
                'narration'=>['nullable','string']
            ],
            ['required'  =>':attribute is required'],
            [
                'ben_id'   =>'Beneficiary',
                'pin'   =>'Account Pin',
            ]
        )->stopOnFirstFailure(true);
        return $this->validationFailed($validator, $request, $user,$request->input('ben_id'));
    }
    public function authenticateTransferFromAccount($request,$user){
        $validator = Validator::make($request->all(),
            [
                'bank'=>['required','numeric'],
                'amount'=>['required','numeric'],
                'currency'=>['required','alpha',Rule::in(['NGN','USD']) ],
                'acc_number'=>['required','numeric',],
                'acc_name'=>['nullable',],
                'routing_number'=>['nullable','numeric',],
                'narration'=>['nullable','string']
            ],
            ['required'  =>':attribute is required'],
            [
                'routing_number'   =>'Routing Number',
                'acc_number'   =>'Account Number',
                'acc_name'   =>'Account Name',
            ]
        )->stopOnFirstFailure(true);
        return $this->validationFailed($validator, $request, $user);
    }
    public function authenticateUSDTransfer($data,$user,$ben){

    }
    public function authenticateNGNTransfer($data,$user,$ben){
        $gateway = new FlutterWave();
        //get transfer charge
        $transferCharge = $gateway->getTransferCharge($data->input('amount'),$data->input('currency'),'account');
        if ($transferCharge->ok()){
            $transferCharge = $transferCharge->json();
            $charge = $transferCharge['data'][0]['fee']+10;
        }else{
            $charge = 40;
        }
        $amount = $data->input('amount')+$charge;
        //lets check the account balance
        $userBalance = MerchantBalances::where('merchant',$user->id)->where('currency',strtoupper($data->input('currency')))->first();
        if ($userBalance->TransactionLimit < $amount){
            return $message = $this->sendError('Error validation', ['error' => 'Amount must not exceed account transaction limit'], '422',
                'Validation Failed');
        }
        if ($userBalance->availableBalance < $amount){
            return $message = $this->sendError('Error validation', ['error' => 'Insufficient balance. Please topup your account first to proceed'], '422',
                'Validation Failed');
        }
        $code = new RandomString('3');
        $code = $code->randomAlpha();
        $reference = $code.'_'.date('dmYhis',time()).mt_rand();
        $data_search = array('crypto','bitcoin','cryptocurrency','ethereum','Cryptocurrency','Crypto');
        $narration = (!empty($data->input('narration'))) ? str_replace($data_search,'merit',$data->input('narration')): 'Transfer from '.$user->name;
        $newBalance = $userBalance->availableBalance - $amount;
        $dataBalance =['availableBalance'=>$newBalance];
        $dataTransfer = [
            'beneficiary'=>$ben,
            'amount'=>$data->input('amount'),
            'currency'=>$data->input('currency'),
            'reference'=>$reference,
            'narration'=>$narration,
            'callback_url'=>config('app.url').'/withdrawal_callback/merchant/'.$user->id.'/reference/'.$reference,
        ];
        $transfer = $gateway->createTransfer($dataTransfer);
        if ($transfer->ok()){
            $transfer = $transfer->json();
            $dataTransaction = [
                'user'=>$user->id,'title'=>'Account Withdrawal','transactionRef'=>$reference, 'transId'=>$transfer['data']['id'],
                'currency'=>strtoupper($data->input('currency')), 'amount'=>$data->input('amount'),
                'amountCredit'=>$data->input('amount'), 'amountCharged'=>$amount, 'charge'=>$charge,
                'status'=>2,'transactionType'=>2
            ];
            $dataWithdrawal = [
                'user'=>$user->id, 'amount'=>$data->input('amount'), 'currency'=>$data->input('currency'),
                'reference'=>$reference, 'withdrawalRef'=>$reference, 'withdrawalId'=>$transfer['data']['id'],
            ];
            $dataCharge = [
                'amount'=>$data->input('amount'),'charge'=>$charge,'flutCharge'=>$transfer['data']['fee'],
                'currency'=>$data->input('currency'),
                'reference'=>$reference
            ];
            //create records
            $addTransactions = Transactions::create($dataTransaction);
            if (!empty($addTransactions)){
                transfers::create($dataWithdrawal);
                UserBalances::where('user',$user->id)->where('id',$userBalance->id)->update($dataBalance);
                Charges::create($dataCharge);
                $details = 'Your ' . $userBalance->currency . ' Account Balance has been debited of <b>' . $userBalance->currency.'
                             ' . number_format($data->input('amount'),2) . '</b>
                             for <b>'.$narration.'</b>   at ' . date('d-m-Y h:i:s a') . '.
                             Your new account balance is <b>'.$userBalance->currency.' '.number_format($newBalance,2).'</b>' ;
                $dataActivity = ['merchant' => $user->id, 'activity' => 'Account Transfer', 'details' => $details,
                    'agent_ip' => $data->ip()];
                event(new AccountActivity($user, $dataActivity));
                event(new SendNotification($user, $details, '3'));
                //send feedback
                $success['sent']=true;
                return $this->sendResponse($success, $transfer['message']);
            }
        }else{
            $transfer=$transfer->json();
            return $message = $this->sendError('Error validation', ['error' => 'Unable to process request.
            Try again or contact support'], '422',
                'Validation Failed');
        }
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function validationFailed(\Illuminate\Contracts\Validation\Validator $validator, $request, $user,$bene)
    {
        if ($validator->fails()) {
            $message = $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422',
                'Validation Failed');
        } else {
            //check if the beneficiary Id supplied is valid
            $beneficiaryExists = UserBeneficiary::where('user',$user->id)->where('beneficiaryId',$bene)->first();
            if (empty($beneficiaryExists)){
                return $message = $this->sendError('Error validation', ['error' => 'Invalid Recipient Account'], '422',
                    'Validation Failed');
            }
            //check if the transaction pin is set
            if ($user->setPin !=1){
                return $message = $this->sendError('Error validation', ['error' => 'Please set your transaction pin first'], '422',
                    'Validation Failed');
            }
            $hashed = Hash::check($request->input('pin'),$user->transPin);
            if (!$hashed){
                return $message = $this->sendError('Error validation', ['error' => 'Invalid transaction pin'], '422',
                    'Validation Failed');
            }
            switch ($request->input('currency')) {
                case 'NGN':
                    return $message = $this->authenticateNGNTransfer($request, $user,$bene);
                    break;
                default:
                    return $message = $this->sendError('Error validation', ['error' => 'Direct Transfer from USD is not currently supported.
                                      Please convert to NGN to proceed.'], '422',
                        'Validation Failed');
                    break;
            }
        }
        return $message;
    }

    /**
     * @param $request
     * @param $user
     */
    public function createBeneficiary($request, $user){

    }
    public function payoutDetails($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transfer = transfers::where('merchant',$user->id)->where('reference',$ref)->first();
        if (empty($transfer)){
            return back()->with('error','Invalid request');
        }
        $transactions = Transactions::where('user',$user->id)->where('transactionRef',$ref)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Details','slogan'=>'- Making safer transactions','user'=>$user,
            'transaction'=>$transactions,'transfer'=>$transfer];
        return view('dashboard.merchant.payout_details',$dataView);
    }
}
