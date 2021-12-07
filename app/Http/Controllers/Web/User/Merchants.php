<?php

namespace App\Http\Controllers\Web\User;

use App\Custom\CustomChecks;
use App\Custom\RandomString;
use App\Custom\Regular;
use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Http\Controllers\Api\BaseController;
use App\Models\Businesses;
use App\Models\BusinessType;
use App\Models\EscrowReports;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\PayBusinessTransactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Merchants extends BaseController
{
    public function index(Request $request){
        $business = $request->get('business');
        $businesses = (!isset($business)) ? Businesses::where('status',1)->orderBy('isVerified','asc')->paginate(15)
            :
            Businesses::where('name','LIKE','%'.$business.'%')->orWhere('businessEmail','LIKE','%'.$business.'%')->orWhere('businessPhone','LIKE','%'.$business.'%')
                ->orWhere('businessCountry','LIKE','%'.$business.'%')->orWhere('businessState','LIKE','%'.$business.'%')->orWhere('businessCity','LIKE','%'.$business.'%')
                ->orWhere('businessAddress','LIKE','%'.$business.'%')->orWhere('Zip','LIKE','%'.$business.'%')->orWhere('businessTag','LIKE','%'.$business.'%')
                ->orderBy('isVerified','asc')->paginate(15);
        $businesses->appends(['business'=>$business]);
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $dataView=['web'=>$generalSettings,'pageName'=>'Merchants','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses,'search'=>$business];
        return view('dashboard.user.merchant_list',$dataView);
    }
    public function details($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $regular = new Regular();
        $checks = new CustomChecks();
        $businessExists = Businesses::where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store or Merchant not found');
        }
        $category = $checks::categoryVar($businessExists->category);
        $subcategory = $checks::subcategoryVar($businessExists->subcategory);
        $businessType = BusinessType::where('id',$businessExists->businessType)->first();
        $escrows = Escrows::where('business',$businessExists->id)->get();

        $completedTransaction = Escrows::where('business',$businessExists->id)
            ->where('status',1)->count();
        $cancelledTransaction = Escrows::where('business',$businessExists->id)
            ->where('status',3)->count();
        $pendingTransactions = Escrows::where('business',$businessExists->id)
            ->where('status',2)->count();
        $reportedTransactions = EscrowReports::where('business',$businessExists->id)
            ->where('merchantLost',1)->count();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Store Information','slogan'=>'- Making safer transactions','user'=>$user,
            'business'=>$businessExists,'type'=>$businessType,'category'=>$category,'subcategory'=>$subcategory,
            'escrows'=>$escrows,
            'completed_transactions'=>$regular->formatNumbers($completedTransaction),
            'pending_transactions'=>$regular->formatNumbers($pendingTransactions),
            'cancelled_transactions'=> $regular->formatNumbers($cancelledTransaction),
            'credit_score'=> (100 -($reportedTransactions/$escrows->count())*100).'%',
            'balances'=>UserBalances::where('user',$user->id)->get(),
            'transactionsWithBusiness'=>PayBusinessTransactions::where('user',$user->id)->where('business',$businessExists->id)->get(),
            'escrowsWithBusiness'=>Escrows::where('user',$user->id)->where('business',$businessExists->id)->paginate(15)
        ];
        return view('dashboard.user.merchant_details',$dataView);
    }
    public function doSendMoney(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'pin'=>['required','digits:6'],
                'currency'=>['required','alpha'],
                'narration'=>['nullable','string'],
                'ref'=>['required',Rule::exists('business','businessRef')->where('status',1) ]
            ],
            ['required'  =>':attribute is required'],
            ['ref'   =>'Business','currency'=>'Balance']
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
        $input = $request->input();
        //check if account pin tallies
        $pinHashed = Hash::check($input['pin'],$user->transPin);
        if (!$pinHashed){
            return $this->sendError('Transfer Error',['error'=>'Invalid Account Pin'],'422',
                'Validation Failed');
        }
        $narration = (empty($input['narration'])) ? 'Payment from '.$user->name : $input['narration'];
        //get currency
        $balance = UserBalances::where('currency',strtoupper($input['currency']))->where('user',$user->id)->first();
        if (empty($balance)){
            return $this->sendError('Transfer Error',['error'=>'Balance not supported'],'422',
                'Validation Failed');
        }
        $transactionLimit = $balance->TransactionLimit;
        if ($input['amount'] > $transactionLimit){
            return $this->sendError('Transfer Error',['error'=>'Amount cannot be greater than your per transaction limit
            of '.$balance->currency.' '.number_format($transactionLimit,2)],'422',
                'Validation Failed');
        }
        $userAvailableBalance = $balance->availableBalance;
        if ($input['amount'] > $userAvailableBalance){
            return $this->sendError('Transfer Error',['error'=>'Insufficient fund in '.$balance->currency.' account'],'422',
                'Validation Failed');
        }
        $userNewBalance = $userAvailableBalance - $input['amount'];
        $charge = 0;
        //get business associated to transaction
        $business = Businesses::where('businessRef',$input['ref'])->first();
        $merchant = User::where('id',$business->merchant)->first();
        $merchantBalance = MerchantBalances::where('currency',strtoupper($input['currency']))->where('merchant',$merchant->id)->first();
        //Merchant Balance
        $merchantAvailableBalance = $merchantBalance->availableBalance;
        $merchantNewBalance = $merchantAvailableBalance + $input['amount'];

        $code = new RandomString(6);
        $reference = $code->randomStr().date('dmYhis');
        //if everything checks out, there is no need to keep the funds in pending since it is a direct transfer
        $userBalanceData=['availableBalance'=>$userNewBalance];
        $merchantBalanceData=['availableBalance'=>$merchantNewBalance];
        //prepare data for transaction
        $transactionData =['user'=>$user->id,'merchant'=>$merchant->id,'business'=>$business->id,'amount'=>$input['amount'],
        'charge'=>$charge,'amountCredited'=>$input['amount']-$charge,'currency'=>$input['currency'],'status'=>1,'narration'=>$narration,
        'reference'=>$reference,'name'=>$user->name];
        //add to database
        $add = PayBusinessTransactions::create($transactionData);
        if (!empty($add)){
            //update user balance as well as that of merchant
            UserBalances::where('id',$balance->id)->update($userBalanceData);
            MerchantBalances::where('id',$merchantBalance->id)->update($merchantBalanceData);

            //create the notification both to mail of merchant and that of user
            //add activity for user
            $details = 'Your transfer of <b>'.$input['currency'].number_format($input['amount'],2).'</b> to <b>'.$business->name.'</b>
                        was successful. Your new available balance is <b>'.$input['currency'].number_format($userNewBalance,2).'</b>.
                        Your Transaction reference is <b>'.$reference.'</b>';
            $dataActivityUser = ['user' => $user->id, 'activity' => 'Payment to Merchant', 'details' => $details,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivityUser));
            event(new EscrowNotification($user, $details, 'Payment to '.$business->name));

            //Send Notification to Merchant
            $detailsToMerchant = 'You have received <b>'.$input['currency'].number_format($input['amount'],2).'</b>
                                from <b>'.$user->name.'</b>. Your new available balance is <b>'.$input['currency'].number_format($merchantNewBalance,2).'</b>.
                                Transaction reference is <b>' . $reference . '</b><br>
                                If you have any Questions, please contact your client or reach out to us at <b>'.$generalSettings->legalMail.'</b> for help.';
            $dataActivityMerchant = ['merchant' => $merchant->id, 'activity' => 'Receipt from '.$user->name, 'details' => $detailsToMerchant,
                'agent_ip' => $request->ip()];
            event(new EscrowNotification($merchant, $detailsToMerchant, 'Receipt from '.$user->name));
            event(new AccountActivity($merchant, $dataActivityMerchant));
            $success['paid'] = true;
            return $this->sendResponse($success, 'Payment Sent');
        }
        return $this->sendError('Transfer Error',['error'=>'An error occurred while trying to transfer to this business'],'422',
            'Validation Failed');
    }
}
