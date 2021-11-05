<?php

namespace App\Http\Controllers\Web\User;

use App\Custom\FlutterWave;
use App\Custom\RandomString;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\AccountFunding;
use App\Models\Airtimes;
use App\Models\CurrencyAccepted;
use App\Models\DepositMethods;
use App\Models\GeneralSettings;
use App\Models\Invoices;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserActivities;
use App\Models\UserBalances;
use App\Models\UserBeneficiary;
use App\Models\UserReferrals;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Dashboard extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $referrals = User::where('refBy',$user->username)->where('status',1)->count();
        $ref_count = $referrals / $generalSettings->referral_celebrate;
        $celebrate_ref = ($ref_count >= 1) ? 1:2;
        $balance = UserBalances::where('user',$user->id)->where('currency',$user->majorCurrency)->first();
        $userBalances = UserBalances::join('currency_accepted','currency_accepted.code','user_balances.currency')->where('user',$user->id)->get();
        $escrows = Invoices::where('user',$user->id)->limit('5')->orderBy('id','desc')->get();
        $airtimes = Airtimes::where('country',$user->countryCode)->where('status',1)->get();
        $currencies = CurrencyAccepted::where('status',1)->get();
        $banks = AcceptedBanks::where('status',1)->get();
        $beneficiaries = UserBeneficiary::where('user',$user->id)->where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Dashboard','slogan'=>'- Making safer transactions','user'=>$user,
            'referrals'=>$referrals,'celebrate_ref'=>$celebrate_ref,'balance'=>$balance,'escrows'=>$escrows,'balances'=>$userBalances,
            'airtimes'=>$airtimes,'currencies'=>$currencies,'banks'=>$banks,'beneficiaries'=>$beneficiaries];
        return view('dashboard.user.home',$dataView);
    }
    public function getDepositMethod($currency){
        $currency = strtoupper($currency);
        $methodExists = DepositMethods::where('currency',$currency)->get();
        if (count($methodExists)<1){
            return $this->sendError('Data Error',['error'=>'unable to fetch data'],'401','No Date Fetched');
        }
        $dataMethod = [];
        foreach ($methodExists as $methodExist){
            $dataMethods['name']=$methodExist->name;
            $dataMethods['code']=$methodExist->code;
            $dataMethods['icon']=$methodExist->icon;
            $dataMethods['currency']=$methodExist->currency;
            $dataMethods['ids']=$methodExist->id;
            $dataMethods['c']=$methodExist->isCard;
            array_push($dataMethod,$dataMethods);
        }

        return $this->sendResponse($dataMethod, 'Data Retrieved');
    }
    public function getDepositMethodId($id){
        $methodExists = DepositMethods::where('id',$id)->first();
        if (empty($methodExists)){
            return $this->sendError('Data Error',['error'=>'unable to fetch data'],'401','No Date Fetched');
        }
        $dataMethods['name']=$methodExists->name;
        $dataMethods['code']=$methodExists->code;
        $dataMethods['icon']=$methodExists->icon;
        $dataMethods['currency']=$methodExists->currency;
        $dataMethods['ids']=$methodExists->id;
        $dataMethods['c']=$methodExists->isCard;
        $dataMethods['redirects']=$methodExists->redirects;

        return $this->sendResponse($dataMethods, 'Data Retrieved');
    }
    public function getBanks($country){
        $banks = AcceptedBanks::where('status',1)->where('country',strtoupper($country))->get();
        $bankData = [];
        foreach ($banks as $bank) {
            $dataBank['name']=$bank->name;
            $dataBank['code']=$bank->bankCode;
            array_push($bankData,$dataBank);
        }
        return $this->sendResponse($bankData,'Banks fetched');
    }
    public function getBanksByCurrency($currency){
        $banks = AcceptedBanks::where('status',1)->where('currency',strtoupper($currency))->orderBy('name','asc')->get();
        $bankData = [];
        foreach ($banks as $bank) {
            $dataBank['name']=$bank->name;
            $dataBank['code']=$bank->bankCode;
            array_push($bankData,$dataBank);
        }
        return $this->sendResponse($bankData,'Banks fetched');
    }
    public function getBank($bankCode){
        $user =Auth::user();
        $bank = AcceptedBanks::where('status',1)->where('bankCode',$bankCode)->first();

        $dataBank['name']=$bank->name;
        $dataBank['code']=$bank->bankCode;
        $dataBank['dob']=$bank->needsDOB;
        $dataBank['auth']=$bank->hasAuthUrl;
        $dataBank['bvn']=$bank->needsBVN;
        $dataBank['hasBVN']=$user->hasBvn;
        $dataBank['hasDob']=$user->hasDob;
        return $this->sendResponse($dataBank,'Banks fetched');
    }
    public function createBankTransferCharge(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric','min:100'],'bank'=>['bail','numeric','required'],'account_number'=>['required','numeric'],
                'dob'=> ['nullable','date'],'phone'=>'required|numeric'
            ],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Amount','account_number'=>'Account number','dob'=>'Date of Birth','bank'=>'Bank']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        //get the Bank with given code
        $bank = AcceptedBanks::where('bankCode',$request->bank)->where('status',1)->first();
        if ($bank->needsDOB ==1 && $user->hasDob !=1 && empty($request->input('dob'))){
            return $this->sendError('Funding Error',['error'=>'Incomplete profile. Please complete your profile or fund through card'],'422','Funding Failed');
        }
        //lets determine which of the date of births to use
        if ($bank->needsDOB==1){
            if ($user->hasDob == 1){
                $passcode = date('dmY',strtotime($user->DOB));
            }elseif(!empty($request->input('dob'))){
                $passcode = date('dmY',strtotime($request->input('dob')));
            }
        }
        //get the user balance correpsonding tho this currency and know if user is allowed
        $userBalance = UserBalances::where('user',$user->id)->where('currency',strtoupper($bank->currency))->first();
        $userTransactionLimit = $userBalance->TransactionLimit;
        if ($userTransactionLimit!=0 && $userTransactionLimit<$request->input('amount')){
            return $this->sendError('Funding Error',['error'=>'Transacted amount is greater than your transaction threshold.
            This could be because your account is not yet verified, or on a lower account tier. Contact support to help you increase
            this limit.'],'422','Funding Failed');
        }
        $code= new RandomString('3');
        $transRef = $code->randomAlpha().date('dmYhis').mt_rand();
        switch ($bank->needsDOB){
            case 1:
                $dataBank = [
                    'account_number'=>$request->input('account_number'),
                    'account_bank'=>$bank->bankCode,
                    'amount'=>$request->input('amount'),
                    'email'=>$user->email,
                    'currency'=>strtoupper($bank->currency),
                    'fullname'=>$user->name,
                    'phone_number'=>$request->input('phone'),
                    'tx_ref'=>$transRef,
                    'passcode'=>$passcode
                ];
                break;
            case 2:
                $dataBank = [
                    'account_number'=>$request->input('account_number'),
                    'account_bank'=>$bank->bankCode,
                    'amount'=>$request->input('amount'),
                    'email'=>$user->email,
                    'currency'=>strtoupper($bank->currency),
                    'fullname'=>$user->name,
                    'phone_number'=>$request->input('phone'),
                    'tx_ref'=>$transRef
                ];
                break;
        }
        //check if BVN is needed
        if ($bank->needsBVN ==1){
            //check if user has bvn added
            if ($user->hasBvn !=1){
                return $this->sendError('Funding Error',['error'=>'Your account is unverified. Please complete your profile or fund through card'],'422','Funding Failed');
            }else{
                $bvn = Crypt::decryptString($user->secret_id);
                Arr::add($dataBank,'bvn',$bvn);
            }
        }
        //initialize the charge
        $gateWay = new FlutterWave();
        $chargeResponse = $gateWay->chargeNgnAccount($dataBank);
        if ($chargeResponse->ok()){
            $chargeResponse=$chargeResponse->json();
            $dataTransaction =[
                'user'=>$user->id,
                'title'=>'Account Funding',
                'transactionRef'=>$transRef,
                'currency'=>strtoupper($bank->currency),
                'amount'=>$request->input('amount'),
                'charge'=>0,
                'transactionType'=>1,
                'processingFee'=>$chargeResponse['data']['app_fee'],
                'amountCharged'=>$chargeResponse['data']['charged_amount'],
                'amountCredit'=>($chargeResponse['data']['charged_amount']-$chargeResponse['data']['app_fee']),
                'transId'=>$chargeResponse['data']['id'],
                'flw_ref'=>$chargeResponse['data']['flw_ref']
            ];
            $addTransactions = Transactions::create($dataTransaction);
            if (!empty($addTransactions)){
                $success['ref']=$chargeResponse['data']['flw_ref'];
                $success['response']=$chargeResponse['data']['processor_response'];
                $success['amount_charged']=$chargeResponse['data']['charged_amount'];
                $success['amount']=$chargeResponse['data']['amount'];
                $success['charge']=$chargeResponse['data']['app_fee'];
                $success['auth_url']=$chargeResponse['data']['auth_url'];
                $success['payment_type']=$chargeResponse['data']['payment_type'];
                $success['bank']=$bank->bankCode;
                return $this->sendResponse($success, $chargeResponse['data']['processor_response']);
            }else{
                return $this->sendError('Funding Error',['error'=>'An error occurred while trying to charge your account'],
                    '422','Funding Failed');
            }
        }else{
            $chargeResponse=$chargeResponse->json();
            return $this->sendError('Funding Error',['error'=>$chargeResponse['message'].' If error persist, it means that either your bank is not yet connected
            or does not support the selected payment channel; try funding with card or contact our support' ],'422','Funding Failed');
        }
    }
    public function completeOtpCharge(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['otp' => ['bail','required','numeric'],'ref'=>['bail','required'],'charge_type'=>['required']],
            ['required'  =>':attribute is required'],
            ['otp'   =>'One Time Password','ref'=>'Transaction Reference','charge_type'=>'Charge Type']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }

        $dataOtp=[
            'otp'=>$request->input('otp'),
            'flw_ref'=>$request->input('ref'),
            'type'=>$request->input('charge_type')
        ];
        $gateWay = new FlutterWave();
        $chargeResponse = $gateWay->validateCharge($dataOtp);
        if ($chargeResponse->ok()){
            $chargeResponse = $chargeResponse->json();
            $paymentStatus = $chargeResponse['data']['status'];//transaction status
            //get transaction
            $transaction = Transactions::where('user',$user->id)->where('transId',$chargeResponse['data']['id'])->first();
            $balance = UserBalances::where('user',$user->id)->where('currency',$transaction->currency)->first();
            if (strtolower($paymentStatus) == 'successful'){
                $new_balance = $transaction->amountCredit+$balance->frozenBalance;
                $dataTransaction =['status'=>1,'paymentStatus'=>1,'datePaid'=>time()];
                $dataBalance = ['frozenBalance'=>$new_balance];
                $dataAccountFunding = ['user'=>$user->id,'amount'=>$transaction->amount,'currency'=>$transaction->currency,'fundingRef'=>$transaction->transactionRef,
                    'transactionId'=>$transaction->transId,'paymentMethod'=>$chargeResponse['data']['payment_type'],
                    'narration'=>$chargeResponse['data']['narration'],'datePaid'=>time(),'status'=>1,'timeSettle'=>strtotime('tomorrow')];
                $updateTransaction = Transactions::where('id',$transaction->id)->update($dataTransaction);
                $updateBalance = UserBalances::where('id',$balance->id)->update($dataBalance);
                if (!empty($updateBalance) && !empty($updateTransaction)) {
                    AccountFunding::create($dataAccountFunding);
                    $details = 'Your ' . $balance->currency . ' Account Balance has been credited with <b>' . $balance->currency.'
                             ' . number_format($transaction->amountCredit,2) . '</b> from '.$transaction->title.'   at ' . date('d-m-Y h:i:s a') . '.
                             Your new account balance is <b>'.$balance->currency.' '.number_format($new_balance,2).'</b>' ;
                    $dataActivity = ['user' => $user->id, 'activity' => 'Account Balance Funding', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                    event(new SendNotification($user, $details, '3'));
                    $success['completed']=true;
                    return $this->sendResponse($success, $chargeResponse['data']['processor_response']);
                }else{
                    return $this->sendError('Funding Error',['error'=>'An unknown error occurred. Please contact our support'],
                        '422','Funding Failed');
                }
            }else{
                $dataTransaction =['status'=>3,'paymentStatus'=>3];
                $updateTransaction = Transactions::where('id',$transaction->id)->update($dataTransaction);
                if (!empty($updateTransaction)) {
                    $details = 'Your attempted account funding has timed out or failed due to '.$chargeResponse['data']['processor_response'].' Please try again or contact our support.' ;
                    $dataActivity = ['user' => $user->id, 'activity' => 'Failed Account Balance Funding', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                    event(new SendNotification($user, $details, '3'));
                }else{
                    return $this->sendError('Funding Error',['error'=>'An unknown error occurred. Please contact our support'],
                        '422','Funding Failed');
                }
                return $this->sendError('Funding Error',['error'=>'Funding failed -'.$chargeResponse['data']['processor_response']],'422','Funding Failed');
            }
        }else{
            $chargeResponse=$chargeResponse->json();
            return $this->sendError('Funding Error',['error'=>$chargeResponse['message']],'422','Funding Failed');
        }
    }
    public function setPin(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['pin' => ['bail','required','numeric','digits:6'],'confirm_pin' => ['bail','required','numeric','digits:6'],'password' => ['bail','required']],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Transaction Pin','confirm_pin'=>'Confirm Transaction Pin']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $hashed = Hash::check($request->input('password'),$user->password);
        if ($hashed){
            $dataUser =['transPin'=>bcrypt($request->input('pin')),'setPin'=>1];
            $update = User::where('id',$user->id)->update($dataUser);
            if (!empty($update)){
                $details = 'Your '.config('app.name').' Transaction pin was successfully set.' ;
                $dataActivity = ['user' => $user->id, 'activity' => 'Security update', 'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                event(new SendNotification($user, $details, '3'));
                $success['completed']=true;
                return $this->sendResponse($success, 'Account Pin successfully updated');
            }else{
                return $this->sendError('Invalid Request',['error'=>'Unknown error encountered'],'422','Security update fail');
            }
        }
        return $this->sendError('Invalid Request',['error'=>'Invalid account password'],'422','Validation Failed');
    }
    public function getFlutterwavePubKey(){
        $user=Auth::user();
        $gateway = new FlutterWave();
        $pubKey = $gateway->returnPublicKey();
        $code= new RandomString('3');
        $payment_ref =$code->randomAlpha().'_'.date('dmYhis').mt_rand();
        $success['publicKey'] = $pubKey;
        $success['ref'] = $payment_ref;
        $success['country'] = $user->countryCode;
        $success['email'] = $user->email;
        $success['name'] = $user->name;
        return $this->sendResponse($success, 'Retrieved');
    }
    public function verifyTransaction(Request $request,$ref){
        $user=Auth::user();
        $ref=htmlentities($ref);
        $gateway = new FlutterWave();
        $transaction = $gateway->verifyTransactionId($ref);
        if ($transaction->ok()){
            $trans =$transaction->json();
            if ($trans['data']['status'] =='successful') {
                $dataTransaction = [
                    'user' => $user->id,
                    'title' => 'Account Funding',
                    'transactionRef' => $trans['data']['tx_ref'],
                    'currency' => strtoupper($trans['data']['currency']),
                    'amount' => $trans['data']['amount'],
                    'charge' => 0,
                    'transactionType' => 1,
                    'processingFee' => $trans['data']['app_fee'],
                    'amountCharged' => $trans['data']['charged_amount'],
                    'amountCredit' => ($trans['data']['charged_amount'] - $trans['data']['app_fee']),
                    'transId' => $trans['data']['id'],
                    'flw_ref' => $trans['data']['flw_ref'],
                    'status'=>1,'paymentStatus'=>1,'datePaid'=>time()
                ];
                $addTransactions = Transactions::create($dataTransaction);
                $balance = UserBalances::where('user',$user->id)->where('currency',strtoupper($trans['data']['currency']))->first();
                $new_balance = ($trans['data']['charged_amount'] - $trans['data']['app_fee'])+$balance->frozenBalance;
                $dataBalance = ['frozenBalance'=>$new_balance];

                $dataAccountFunding = [
                    'user'=>$user->id,
                    'amount'=>$trans['data']['amount'],
                    'currency'=>strtoupper($trans['data']['currency']),
                    'fundingRef'=>$trans['data']['tx_ref'],
                    'transactionId'=>$trans['data']['id'],
                    'paymentMethod'=>$trans['data']['payment_type'],
                    'narration'=>$trans['data']['narration'],
                    'datePaid'=>time(),
                    'status'=>1,
                    'timeSettle'=>strtotime('tomorrow')
                ];
                $updateBalance = UserBalances::where('id',$balance->id)->update($dataBalance);
                if (!empty($updateBalance) && !empty($addTransactions)) {
                    AccountFunding::create($dataAccountFunding);
                    $details = 'Your ' . $balance->currency . ' Account Balance has been credited with <b>' . $balance->currency.'
                             ' . number_format($trans['data']['amount'],2) . '</b> for account funding   at ' . date('d-m-Y h:i:s a') . '.
                             Your new account balance is <b>'.$balance->currency.' '.number_format($new_balance,2).'</b><br>
                             <b>Note:</b> This amount is will be released to your available balance on '.date('d-m-Y h:i:s a',strtotime('tomorrow'));
                    $dataActivity = ['user' => $user->id, 'activity' => 'Account Balance Funding', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                    event(new SendNotification($user, $details, '3'));
                    $success['completed']=true;
                    return $this->sendResponse($success, 'Account successfully funded');
                }else{
                    return $this->sendError('Funding Error',['error'=>'An unknown error occurred. Please contact our support'],
                        '422','Funding Failed');
                }
            }else{
                $trans =$transaction->json();
                return $this->sendError('Funding Error',['error'=>$trans['message']],'422','Funding Failed');
            }
        }
    }
    public function convertReferral(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric']],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Withdrawal Amount']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $refBalance = UserBalances::where('user',$user->id)->where('currency',$user->majorCurrency)->first();
        return $this->checkReferralBalanceForConversion($request, $refBalance, $user);
    }
    public function convertSpecificReferral(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric'],'currency' => ['bail','required','alpha']],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Withdrawal Amount']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $refBalance = UserBalances::where('user',$user->id)->where('currency',$request->input('currency'))->first();
        return $this->checkReferralBalanceForConversion($request, $refBalance, $user);
    }

    /**
     * @param Request $request
     * @param $refBalance
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkReferralBalanceForConversion(Request $request, $refBalance, ?\Illuminate\Contracts\Auth\Authenticatable $user): \Illuminate\Http\JsonResponse
    {
        if ($request->amount > $refBalance->referralBalance) {
            return $this->sendError('Insufficient Fund', ['error' => 'Insufficient Fund in ' . $refBalance->currency . ' Referral Account'], '422', 'Validation Failed');
        }
        $refBal = $refBalance->referralBalance - $request->amount;
        $newBal = $refBalance->availableBalance + $request->amount;
        $balData = [
            'availableBalance' => $newBal,
            'referralbalance' => $refBal
        ];
        $updateBalance = UserBalances::where('id', $refBalance->id)->update($balData);
        if (!empty($updateBalance)) {
            $details = 'Your ' . $refBalance->currency . ' Referral Balance was debited of ' . $refBalance->currency . '
                        ' . $request->amount . ' at ' . date('d-m-Y h:i:s a') . ' and converted to corresponding available
                        balance';
            $dataActivity = ['user' => $user->id, 'activity' => 'Referral Balance Debit', 'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user, $details, '3'));
            $success['convert'] = true;
            return $this->sendResponse($success, 'conversion successful');
        }
        return $this->sendError('Error Converting', ['error' => 'There was an Error converting'], '4011', 'Conversion Failed');
    }
    public function convertToNGN(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric'],'currency' => ['bail','required','alpha']],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Withdrawal Amount']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $userBalance = UserBalances::where('user',$user->id)->where('currency',$request->input('currency'))->first();
        $acceptedCurrency = CurrencyAccepted::where('code',strtoupper($request->input('currency')))->where('status',1)->first();
        $userNgnBalance = UserBalances::where('user',$user->id)->where('currency','NGN')->first();
        if ($request->input('amount') > $userBalance->availableBalance) {
            return $this->sendError('Insufficient Fund', ['error' => 'Insufficient Fund in ' . $userBalance->currency . ' Available Account'],
                '422', 'Validation Failed');
        }
        $rateNGN = $acceptedCurrency->rateNGN;
        $newAmount = $rateNGN*$request->input('amount');
        $newBal = $userNgnBalance->availableBalance + $newAmount;
        $newCurrBalance = $userBalance->availableBalance - $request->input('amount');
        if ($userNgnBalance->AccountLimit > $newBal){
            return $this->sendError('Error converting',['error'=>'Conversion failed. Amount above account Limit'],
                '422','Conversion Failed');
        }
        $balData = [
            'availableBalance' => $newBal,
        ];
        $convertedBalanceData = [
            'availableBalance' => $newCurrBalance,
        ];
        $updateBalance = UserBalances::where('id', $userNgnBalance->id)->update($balData);
        if (!empty($updateBalance)){
            $updateConvertedBalance = UserBalances::where('id', $userBalance->id)->update($convertedBalanceData);
            $details = 'Your ' . $userBalance->currency . ' Available Balance was debited of ' . $userBalance->currency . '
                        ' . $request->amount . ' at ' . date('d-m-Y h:i:s a') . ' and converted to NGN available
                        balance';
            $dataActivity = ['user' => $user->id, 'activity' => 'Referral Balance Debit', 'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user, $details, '3'));
            $success['convert'] = true;
            return $this->sendResponse($success, 'conversion successful');
        }
        return $this->sendError('Error Converting', ['error' => 'There was an Error converting your '.$userBalance->currency.' balance to NGN'],
            '4011', 'Conversion Failed');
    }
    public function getSpecificCurrencyData($currency){
        $currencyData = CurrencyAccepted::where('code',$currency)->first();
        if (!empty($currencyData)){
            $success['currency']=$currencyData->code;
            $success['name']=$currencyData->currency;
            $success['rateUsd']=$currencyData->rateUsd;
            $success['rateNGN']=$currencyData->rateNGN;
            return $this->sendResponse($success, 'fetched');
        }
        return $this->sendError('Error', ['error' => 'Unsupported currency queried'],
            '4011', 'Fetch Failed');
    }
}
