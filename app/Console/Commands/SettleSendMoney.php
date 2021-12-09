<?php

namespace App\Console\Commands;

use App\Events\SendGeneralMail;
use App\Models\SendMoney;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Console\Command;

class SettleSendMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settle:sendMoney';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settle pending payments from send money endpoint';

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
        $payments = SendMoney::where('paymentStatus',1)->where('settled',2)->where('timeToSettle','<=',$moment)->get();
        if ($payments->count()>0){
            foreach ($payments as $payment) {
                $user = User::where('id',$payment->user)->first();
                $userBalance = UserBalances::where('user', $user->id)->where('currency', $payment->currency)->first();
                $pendingBalance = $userBalance->frozenBalance;
                $availableBalance = $userBalance->availableBalance;
                $newPendingBalance = $pendingBalance - $payment->amountCredit;
                $newAvailableBalance = $availableBalance + $payment->amountCredit;
                $dataBalance = ['frozenBalance' => $newPendingBalance,'availableBalance'=>$newAvailableBalance];
                $dataPayment = ['settled'=>1];
                $update = SendMoney::where('id', $payment->id)->update($dataPayment);
                if ($update) {
                    UserBalances::where('id', $userBalance->id)->update($dataBalance);
                    //mail to user
                    $mail2 = 'Your pending settlement of <b>' . $payment->currency . number_format($payment->amount, 2) . '</b> on
                            ' . config('app.name') . ' from <b>' . $payment->name . '</b> has been settled into your account
                            and is available for use. ';
                    event(new SendGeneralMail($user, $mail2, 'Settlement on '.config('app.name')));
                }
            }
        }
    }
}
