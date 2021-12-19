<?php

namespace App\Http\Controllers\Web\Pay_Merchant;

use App\Custom\FlutterWave;
use App\Custom\RandomString;
use App\Events\SendGeneralMail;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Businesses;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\PaymentLinkPayments;
use App\Models\PaymentLinks;
use App\Models\PaymentLinkSubscriptions;
use App\Models\SendMoney;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Pay extends BaseController
{
    public function index($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $ref= $ref;
        $paymentLink = PaymentLinks::where('reference',$ref)->where('status',1)->first();
        if (empty($paymentLink)){
            abort(404);
        }
        $user = User::where('id',$paymentLink->merchant)->first();
        if (!empty($paymentLink->business)){
            $business = Businesses::where('id',$paymentLink->business)->first();
            $businessName = $business->name;
        }else{
            $businessName = $user->name;
        }
        if (!empty($paymentLink->currency)){
            $currency = CurrencyAccepted::where('code',$paymentLink->currency)->where('status',1)->get();
        }else{
            $currency = CurrencyAccepted::where('status',1)->get();
        }
        $dataView=['web'=>$generalSettings,'pageName'=>'Pay for '.$paymentLink->title,'slogan'=>'- Making safer transactions',
            'currencies'=>$currency,'ref'=>$ref,'user'=>$user,'details'=>$paymentLink, 'businessName'=>$businessName];
        return view('pay-merchant.payment_link.pay',$dataView);
    }
    public function doPay(Request $request){
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
        $ref = $input['ref'];
        $paymentLink = PaymentLinks::where('reference',$ref)->where('status',1)->first();
        if (empty($paymentLink)){
            return back()->with('error','Payment Link not found');
        }
        //get user
        $user = User::where('id',$paymentLink->merchant)->first();
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
        $amount = (empty($paymentLink->amount)) ? $input['amount'] : $paymentLink->amount;
        $amount = str_replace(',','',$amount);
        $charge = $amount * ($currencyExists->charge/100);
        if ($charge > $currencyExists->sendMoneyChargeMax){
            $charge = $currencyExists->sendMoneyChargeMax;
        }elseif ($charge < $currencyExists->sendMoneyChargeMin){
            $charge = $currencyExists->sendMoneyChargeMin;
        }else{
            $charge = $charge;
        }

        switch ($paymentLink->whoPays){
            case 1:
                $amountPaid = $amount;
                $amountCredit = $amountPaid - $charge;
                break;
            default:
                $amountPaid = $amount + $charge;
                $amountCredit = $amountPaid - $charge;
                break;
        }
        $reference = $code->randomStr().date('dmYhis').mt_rand();
        //collate the data needed to initiate the transaction
        $dataCreateCharge = ['amount'=>$amount,'tx_ref'=>$reference,'currency'=>$input['currency'],
            'payment_options'=>'card','redirect_url'=>url('pay/process_payment/'.$reference.'/'.$paymentLink->reference),
            'payment_plan'=>$paymentLink->planId,
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
            $dataPayment = ['amount'=>$amount,'merchant'=>$user->id,'transactionRef'=>$reference,
                'currency'=>strtoupper($input['currency']),'amountPaid'=>$amountPaid,'reference'=>$paymentLink->reference,
                'charge'=>$charge,'amountCredit' =>$amountCredit,'payerName'=>$input['name'],'payerEmail'=>$input['email'],
                'paymentChannel'=>'card','business'=>$paymentLink->business];
            //add to database before redirect
            $add = ($paymentLink->type ==2) ? PaymentLinkSubscriptions::create($dataPayment):PaymentLinkPayments::create($dataPayment);
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
    public function processPayment($ref,$linkRef){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $refs = $ref;
        //get the transaction with reference
        $paymentLink = PaymentLinks::where('reference',$linkRef)->first();
        if (empty($paymentLink)){
            return redirect('index')->with('error','Funding was not found.');
        }
        $payment = ($paymentLink->type == 2) ? PaymentLinkSubscriptions::where('transactionRef',$ref)->first() : PaymentLinkPayments::where('transactionRef',$ref)->first();
        if (empty($payment)){
            return redirect('index')->with('error','Payment not found');
        }
        $user = User::where('id',$payment->user)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Page','slogan'=>'- Making safer transactions',
            'ref'=>$linkRef,'user'=>$user,'payment'=>$payment,'pay_ref'=>$refs];
        return view('pay-merchant.payment_link.process-pay',$dataView);
    }
    public function checkStatus($ref,$pay_ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $gateway = new FlutterWave();
        $refs = $ref;
        $txRef = $pay_ref;
        //get the transaction with reference
        $paymentLink = PaymentLinks::where('reference',$refs)->first();
        if (empty($paymentLink)){
            return $this->sendError('Invalid Request',['error'=>'Payment link Was not found'],
                '422','update fail');
        }
        $payment = ($paymentLink->type == 2) ? PaymentLinkSubscriptions::where('reference',$ref)->where('transactionRef',$txRef)->first() : PaymentLinkPayments::where('reference',$ref)->where('transactionRef',$txRef)->first();
        if (empty($payment)){
            return $this->sendError('Invalid Request',['error'=>'Payment  Was not found'],
                '422','update fail');
        }
        if ($payment->paymentStatus == 3){
            return $this->sendError('Invalid Request',['error'=>'Payment has timed out'],
                '422','update fail');
        }
        if ($payment->paymentStatus == 1){
            $success['paid']=1;
            return $this->sendResponse($success, 'Payment already completed');
        }

        $user = User::where('id',$paymentLink->merchant)->first();
        //check the transaction status of the transaction
        $data=['txref'=>$payment->transactionRef];
        $response = $gateway->verifyTransactionRef($data);
        if ($response->ok()){
            $response = $response->json();
            $status = $response['data']['status'];
            if (strtolower($status) =='successful'){
                //get the user Balance
                $userBalance = MerchantBalances::where('merchant',$user->id)->where('currency',$payment->currency)->first();
                $pendingBalance = $userBalance->frozenBalance;
                $newPendingBalance = $pendingBalance + $payment->amountCredit;
                $dataBalance = ['frozenBalance' => $newPendingBalance];
                $dataPayment = ['paymentStatus'=>1,'timeToSettle'=>strtotime('tomorrow'),
                    'transId'=>$response['data']['txid'],'flutCharge'=>$response['data']['appfee']];
                $dataTransactions = [
                    'title'=>'Transfer from '.$payment->payerName,'user'=>$user->id,'transactionRef'=>$payment->transactionRef,
                    'transId'=>$response['data']['txid'],'currency'=>$payment->currency,'amount'=>$payment->amount,
                    'amountCredit'=>$payment->amountCredit,'amountCharged'=>$payment->amount,'charge'=>$payment->charge,
                    'transactionType'=>7,'paymentStatus'=>1,'status'=>1,'processingFee'=>$response['data']['appfee'],
                    'flw_ref'=>$response['data']['flwref'],'datePaid'=>time()
                ];
                $update = ($paymentLink->type ==2) ? PaymentLinkSubscriptions::where('id',$payment->id)->update($dataPayment):PaymentLinkPayments::where('id',$payment->id)->update($dataPayment);
                if ($update){
                    MerchantBalances::where('id',$userBalance->id)->update($dataBalance);
                    Transactions::create($dataTransactions);
                    //mail to user
                    $mail2 = 'You have received <b>'.$payment->currency.number_format($payment->amount,2).'</b> on
                    '.config('app.name').' from <b>'.$payment->payerName.'</b>. Note that this amount is in your pending
                    balance and will be made available after confirmation of no chargeback.';
                    event(new SendGeneralMail($user, $mail2, 'New Payment from '.$payment->payerName));
                }else{
                    return $this->sendError('Invalid Request',['error'=>'Payment has timed out'],
                        '422','update fail');
                }
                $success['paid']=1;
                return $this->sendResponse($success, 'Payment verified');
            }else{
                $success['paid']=2;
                return $this->sendResponse($success, 'Still verifying');
            }
        }else{
            $response = $response->json();
            $dataPayment = ['paymentStatus'=>3];
            $update =  ($paymentLink->type ==2) ? PaymentLinkSubscriptions::where('id',$payment->id)->update($dataPayment):PaymentLinkPayments::where('ids',$payment->id)->update($dataPayment);
            if ($update){
                $mail = 'Your payment on '.config('app.name').' to <b>'.$user->name.'</b> has been cancelled or timed out.
                        You can nonetheless retry this payment by contacting the merchant.<br>' ;
                //send a mail to the user
                event(new SendGeneralMail($payment, $mail, 'Regarding your payment on '.config('app.name')));
            }
            return $this->sendError('Invalid Request',['error'=>'Payment has timed out'],
                '422','update fail');
        }
    }
}
