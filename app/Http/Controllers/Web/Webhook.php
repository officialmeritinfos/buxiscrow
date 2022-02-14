<?php

namespace App\Http\Controllers\Web;

use App\Events\EscrowNotification;
use App\Http\Controllers\Controller;
use App\Models\AccountFunding;
use App\Models\BankBanks;
use App\Models\CurrencyAccepted;
use App\Models\MerchantBalances;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Http\Request;

class Webhook extends Controller
{
    public function index(Request $request)
    {
        //data received from flutterwave
        $receivedData = $request->input();
        $transactionType = $receivedData['event.type'];
        //perform activities
        switch (strtoupper($transactionType)) {
            case 'BANK_TRANSFER_TRANSACTION':
                return $this->processBankCredit($receivedData);
                break;
            default:
                # code...
                break;
        }
    }
    public function processBankCredit($data)
    {
        $data = $data;
        $bankRef = $data['data']['tx_ref'];
        //lets check the bank that got credited
        $userBank = BankBanks::where('bank_ref',$bankRef)->first();
        if (!empty($userBank)) {
            $user = User::where('id',$userBank->id)->first();
            return $this->creditUserBank($data['data'],$user);
        }
    }
    public function creditUserBank($transData,$user)
    {
        $amountSent = $transData['amount'];
        $charge = $transData['app_fee'];
        $amountCredit = $amountSent - $charge;
        $currency = strtoupper($transData['currency']);
        //get the currency
        $currencyExists = CurrencyAccepted::where('code',$currency)->first();
        //check if this transaction webhook has been received earier to avoid double crediting
        $fundingExists = AccountFunding::where('fundingRef',$transData['flw_ref'])->where('transactionId',$transData['id'])->first();
        if (!empty($fundingExists)) {
            if ($amountSent == $fundingExists->amount) {
                $add = 2;
            }else{
                $add = 1;
            }
        }else{
            $add = 1;
        }
        if($add == 1){
            //lets gather data for account funding
            $dataFunding =[
                'user'=>$user->id,
                'amount'=>$amountSent,
                'currency'=>$currency,
                'fundingRef'=>$transData['flw_ref'],
                'transactionId'=>$transData['id'],
                'paymentMethod'=>'Bank Transfer',
                'narration'=>$transData['narration'],
                'datePaid'=>time(),
                'status'=>1,
                'settled'=>1,
                'timeSettle'=>time(),
                'timeSettled'=>time()
            ];
            $dataTransaction =[
                'title'=>'Account Funding',
                'user'=>$user->id,
                'transactionRef'=>$transData['flw_ref'],
                'transId'=>$transData['id'],
                'currency'=>$currency,
                'amount'=>$amountSent,
                'amountCredit'=>$amountCredit,
                'amountCharged'=>$transData['charged_amount'],
                'charge'=>0,
                'transactionType'=>1,
                'paymentStatus'=>1,
                'status'=>1,
                'processingFee'=>$charge,
                'flw_ref'=>$transData['flw_ref'],
                'datePaid'=>time()
            ];
            $userAccountType = $user->accountType;
            switch ($userAccountType) {
                case '1':
                    $balance = MerchantBalances::where('merchant',$user->id)->where('currency',$currency)->first();
                    $newBalance = $balance->availableBalance + $amountCredit;
                    $dataBalance =['availableBalance'=>$newBalance];
                    break;
                default:
                    $balance = UserBalances::where('user',$user->id)->where('currency',$currency)->first();
                    $newBalance = $balance->availableBalance + $amountCredit;
                    $dataBalance =['availableBalance'=>$newBalance];
                    break;
            }
            //update balance
            if ($userAccountType ==1) {
                $update = MerchantBalances::where('id',$balance->id)->update($dataBalance);
            }else{
                $update = UserBalances::where('id',$balance->id)->update($dataBalance);
            }
            if ($update) {
                AccountFunding::create($dataFunding);
                Transactions::create($dataTransaction);
                //send a mail to user
                $message = "
                            <h1>You just received funds.</h1><br>
                            <p>A new credit transaction just occurred on your ".config('app.name')." account. <br>
                            You Received <b>".$currency.number_format($amountSent,2)."</b> with narration <b>".$transData['narration']."</b>.
                            A processing fee of <b>".$currency.number_format($charge,2)."</b> was charged on the amount received. Your new
                            balance is <b>".$currency.number_format($newBalance,2)."</b>.
                        ";
                event(new EscrowNotification($user, $message,$currency.' '.number_format($amountSent,2).' Received'));
            }
        }
    }
}
