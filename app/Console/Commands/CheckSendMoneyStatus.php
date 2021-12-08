<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Events\SendGeneralMail;
use App\Models\GeneralSettings;
use App\Models\SendMoney;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Console\Command;

class CheckSendMoneyStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sendMoneyStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks to see if the send money endpoint was successful';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $gateway = new FlutterWave();
        $payments = SendMoney::where('paymentStatus',2)->get();
        if ($payments->count()>0){
            foreach ($payments as $payment) {
                $user = User::where('id',$payment->user)->first();
                $ref = $payment->reference;
                //check the transaction status of the transaction
                $data=['txref'=>$ref];
                $response = $gateway->verifyTransactionRef($data);
                if ($response->ok()) {
                    $response = $response->json();
                    $status = $response['data']['status'];
                    if (strtolower($status) == 'successful') {
                        //get the user Balance
                        $userBalance = UserBalances::where('user', $user->id)->where('currency', $payment->currency)->first();
                        $pendingBalance = $userBalance->frozenBalance;
                        $newPendingBalance = $pendingBalance + $payment->amountCredit;
                        $dataBalance = ['frozenBalance' => $newPendingBalance];
                        $dataPayment = ['paymentStatus' => 1, 'statusMessage' => 'Payment Received', 'timeToSettle' => strtotime('tomorrow'),
                            'transId' => $response['data']['txid'], 'flutCharge' => $response['data']['appfee']];
                        $dataTransactions = [
                            'title' => 'Transfer from ' . $payment->name, 'user' => $user->id, 'transactionRef' => $payment->reference,
                            'transId' => $response['data']['txid'], 'currency' => $payment->currency, 'amount' => $payment->amount,
                            'amountCredit' => $payment->amountCredit, 'amountCharged' => $payment->amount, 'charge' => $payment->charge,
                            'transactionType' => 7, 'paymentStatus' => 1, 'status' => 1, 'processingFee' => $response['data']['appfee'],
                            'flw_ref' => $response['data']['flwref'], 'datePaid' => time()
                        ];
                        $update = SendMoney::where('id', $payment->id)->update($dataPayment);
                        if ($update) {
                            UserBalances::where('id', $userBalance->id)->update($dataBalance);
                            Transactions::create($dataTransactions);
                            //mail to user
                            $mail2 = 'You have received <b>' . $payment->currency . number_format($payment->amount, 2) . '</b> on
                            ' . config('app.name') . ' from <b>' . $payment->name . '</b>. Note that this amount is in your pending
                            balance and will be made available after confirmation of no chargeback.';
                            event(new SendGeneralMail($user, $mail2, 'Regarding your payment from ' . $payment->name));
                        }
                    }
                }else {
                    $response = $response->json();
                    $dataPayment = ['paymentStatus' => 3, 'statusMessage' => 'Payment was cancelled'];
                    $update = SendMoney::where('id', $payment->id)->update($dataPayment);
                    if ($update) {
                        $mail = 'Your payment on ' . config('app.name') . ' to <b>' . $user->name . '</b> has been cancelled or timed out.
                        You can nonetheless retry this payment by using the link <a href="' . url('send-money/' . $user->userRef) . '"
                        target="_blank">' . url('send-money/' . $user->userRef) . '</a><br>';
                        //send a mail to the user
                        event(new SendGeneralMail($payment, $mail, 'Regarding your payment on ' . config('app.name')));
                    }
                }
            }
        }
    }
}
