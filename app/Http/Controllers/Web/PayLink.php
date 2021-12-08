<?php

namespace App\Http\Controllers\Web;

use App\Custom\FlutterWave;
use App\Custom\RandomString;
use App\Events\EscrowNotification;
use App\Events\SendGeneralMail;
use App\Http\Controllers\Api\BaseController;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\SendMoney;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayLink extends BaseController
{
    public function index($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $currency =CurrencyAccepted::where('status',1)->get();
        $ref= $ref;
        $user = User::where('userRef',$ref)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Page','slogan'=>'- Making safer transactions',
            'currencies'=>$currency,'ref'=>$ref,'user'=>$user];
        return view('send-money.send-money',$dataView);
    }
    public function doSend(Request $request){
        $web = GeneralSettings::where('id',1)->first();
        $validator = Validator::make($request->all(), [
            'email' => ['bail','required','email'],
            'amount' => ['bail','required','string'],
            'name' => ['bail','required','string'],
            'currency' => ['bail','required','alpha'],
            'ref' => ['bail','required','string'],
        ])->stopOnFirstFailure(true);

        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        //get user
        $user = User::where('userRef',$input['ref'])->first();
        //check if the currency is supported
        $currencyExists = CurrencyAccepted::where('code',$input['currency'])->first();
        if (empty($currencyExists)){
            return back()->with('error','Unsupported currency parameter');
        }
        if (empty($user)){
            return back()->with('error','User not found');
        }
        $code = new RandomString(4);
        $gateway = new FlutterWave();
        $amount = str_replace(',','',$input['amount']);
        $charge = $amount * ($currencyExists->charge/100);
        if ($charge > $currencyExists->sendMoneyChargeMax){
            $charge = $currencyExists->sendMoneyChargeMax;
        }elseif ($charge < $currencyExists->sendMoneyChargeMin){
            $charge = $currencyExists->sendMoneyChargeMin;
        }else{
            $charge = $charge;
        }
        $reference = $code->randomStr().date('dmYhis').mt_rand();
        //collate the data needed to initiate the transaction
        $dataCreateCharge = ['amount'=>$amount,'tx_ref'=>$reference,'currency'=>$input['currency'],
            'payment_options'=>'card','redirect_url'=>url('send-money/process_payment/'.$reference),
            'customer'=>[
                'name'=>$input['name'],
                'email'=>$input['email']
            ],
            'customizations'=>[
                'title'=>'Send Money to '.$user->name,
                'logo'=>asset('home/img/'.$web->favicon)
            ]
        ];
        $createCharge = $gateway->initiatePayment($dataCreateCharge);
        if ($createCharge->ok()){
            $response = $createCharge->json();
            $dataPayment = ['amount'=>$amount,'user'=>$user->id,'reference'=>$reference,'currency'=>strtoupper($input['currency']),
                'charge'=>$charge,'amountCredit' =>$amount-$charge,'name'=>$input['name'],'email'=>$input['email']];
            //add to database before redirect
            $add = SendMoney::create($dataPayment);
            if (!empty($add)){
                return redirect($response['data']['link']);
            }else{
                return back()->with('error','An error occurred trying to initiate your transfer');
            }
        }else{
            $response = $createCharge->json();
            return back()->with('error',$response['message']);
        }
    }
    public function processPayment($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $refs = $ref;
        //get the transaction with reference
        $payment = SendMoney::where('reference',$refs)->first();
        if (empty($payment)){
            return redirect('index')->with('error','Funding was not found.');
        }
        $user = User::where('id',$payment->user)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Page','slogan'=>'- Making safer transactions',
            'ref'=>$refs,'user'=>$user,'payment'=>$payment];
        return view('send-money.process-sendMoney',$dataView);
    }
    public function checkStatus($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $gateway = new FlutterWave();
        $refs = $ref;
        //get the transaction with reference
        $payment = SendMoney::where('reference',$refs)->first();
        if (empty($payment)){
            return $this->sendError('Invalid Request',['error'=>'Payment Was not found'],
                '422','update fail');
        }
        if ($payment->paymentStatus == 3){
            return $this->sendError('Invalid Request',['error'=>'Payment has timed out'],
                '422','update fail');
        }
        $user = User::where('id',$payment->user)->first();
        //check the transaction status of the transaction
        $data=['txref'=>$ref];
        $response = $gateway->verifyTransactionRef($data);
        if ($response->ok()){
            $response = $response->json();
            $status = $response['data']['status'];
            if (strtolower($status) =='successful'){
                //get the user Balance
                $userBalance = UserBalances::where('user',$user->id)->where('currency',$payment->currency)->first();
                $pendingBalance = $userBalance->frozenBalance;
                $newPendingBalance = $pendingBalance + $payment->amountCredit;
                $dataBalance = ['frozenBalance' => $newPendingBalance];
                $dataPayment = ['paymentStatus'=>1,'statusMessage'=>'Payment Received','timeToSettle'=>strtotime('tomorrow'),
                    'transId'=>$response['data']['txid'],'flutCharge'=>$response['data']['appfee']];
                $dataTransactions = [
                    'title'=>'Transfer from '.$payment->name,'user'=>$user->id,'transactionRef'=>$payment->reference,
                    'transId'=>$response['data']['txid'],'currency'=>$payment->currency,'amount'=>$payment->amount,
                    'amountCredit'=>$payment->amountCredit,'amountCharged'=>$payment->amount,'charge'=>$payment->charge,
                    'transactionType'=>7,'paymentStatus'=>1,'status'=>1,'processingFee'=>$response['data']['appfee'],
                    'flw_ref'=>$response['data']['flwref'],'datePaid'=>time()
                ];
                $update = SendMoney::where('id',$payment->id)->update($dataPayment);
                if ($update){
                    UserBalances::where('id',$userBalance->id)->update($dataBalance);
                    Transactions::create($dataTransactions);
                    //mail to user
                    $mail2 = 'You have received <b>'.$payment->currency.number_format($payment->amount,2).'</b> on
                    '.config('app.name').' from <b>'.$payment->name.'</b>. Note that this amount is in your pending
                    balance and will be made available after confirmation of no chargeback.';
                    event(new SendGeneralMail($user, $mail2, 'Regarding your payment from '.$payment->name));
                }else{
                    return $this->sendError('Invalid Request',['error'=>'Payment has timed out'],
                        '422','update fail');
                }
                $success['paid']=1;
                return $this->sendResponse($success, 'Payment received');
            }else{
                $success['paid']=2;
                return $this->sendResponse($success, 'Still verifying');
            }
        }else{
            $response = $response->json();
            $dataPayment = ['paymentStatus'=>3,'statusMessage'=>'Payment was cancelled'];
            $update = SendMoney::where('id',$payment->id)->update($dataPayment);
            if ($update){
                $mail = 'Your payment on '.config('app.name').' to <b>'.$user->name.'</b> has been cancelled or timed out.
                        You can nonetheless retry this payment by using the link <a href="'.url('send-money/'.$user->userRef).'"
                        target="_blank">'.url('send-money/'.$user->userRef).'</a><br>' ;
                //send a mail to the user
                event(new SendGeneralMail($payment, $mail, 'Regarding your payment on '.config('app.name')));
            }
            return $this->sendError('Invalid Request',['error'=>'Payment has timed out'],
                '422','update fail');
        }
    }
}
