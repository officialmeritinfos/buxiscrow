<?php

namespace App\Console\Commands;

use App\Events\SendGeneralMail;
use App\Models\MerchantBalances;
use App\Models\PaymentLinks;
use App\Models\PaymentLinkSubscriptions;
use App\Models\User;
use Illuminate\Console\Command;

class SettlePaymentLinkSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settle:paymentLinkSubscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $moment = time();
        $payments = PaymentLinkSubscriptions::where('paymentStatus',1)->where('settled','!=',1)->where('timeToSettle','<=',$moment)->get();
        if ($payments->count()>0){
            foreach ($payments as $payment) {
                $paymentLink = PaymentLinks::where('reference',$payment->reference)->first();
                $user = User::where('id',$payment->merchant)->first();
                $userBalance = MerchantBalances::where('merchant', $user->id)->where('currency', $payment->currency)->first();
                $pendingBalance = $userBalance->frozenBalance;
                $availableBalance = $userBalance->availableBalance;
                $newPendingBalance = $pendingBalance - $payment->amountCredit;
                $newAvailableBalance = $availableBalance + $payment->amountCredit;
                $dataBalance = ['frozenBalance' => $newPendingBalance,'availableBalance'=>$newAvailableBalance];
                $dataPayment = ['settled'=>1];
                $update = PaymentLinkSubscriptions::where('id', $payment->id)->update($dataPayment);
                if ($update) {
                    MerchantBalances::where('id', $userBalance->id)->update($dataBalance);
                    //mail to user
                    $mail2 = 'Your pending settlement of <b>' . $payment->currency . number_format($payment->amount, 2) . '</b> on
                            ' . config('app.name') . ' from <b>' . $payment->payerName . '</b>  received on your payment link
                            with title <b>'.$paymentLink->title.'</b> and reference <b>'.$paymentLink->reference.'</b>
                            has been settled into your account and is available for use. ';
                    event(new SendGeneralMail($user, $mail2, 'Settlement on '.config('app.name')));
                }
            }
        }
    }
}
