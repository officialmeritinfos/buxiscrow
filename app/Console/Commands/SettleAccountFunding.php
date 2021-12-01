<?php

namespace App\Console\Commands;

use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Models\AccountFunding;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SettleAccountFunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settle:accountFunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs a cron settling every transaction to the appropriate balance';

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
       //get account funding that are pending
        $accountFundings = AccountFunding::where('status',1)->where('settled',2)->where('timeSettle','<=',time())->get();
        if ($accountFundings->count()>0){
            foreach ($accountFundings as $accountFunding) {
                //get user
                $user= User::where('id',$accountFunding->user)->first();
                //get corresponding transaction
                $transaction = Transactions::where('user',$accountFunding->user)->where('transactionRef',$accountFunding->fundingRef)->first();
                //get the user's account balance and check limits
                $userBalance = UserBalances::where('user',$accountFunding->user)->where('currency',strtoupper($accountFunding->currency))->first();
                $transactionLimit = $userBalance->TransactionLimit >=$transaction->amount;

                if ($userBalance->TransactionLimit >= $transaction->amount){
                    if ($userBalance->AccountLimit >= $transaction->amount){
                        $newFrozenBalance = $userBalance->frozenBalance - $transaction->amountCredit;
                        $newBalance = $userBalance->availableBalance + $transaction->amountCredit;
                        $dataBalance = ['availableBalance'=>$newBalance,'frozenBalance'=>$newFrozenBalance];
                        $dataAccountFunding = ['settled'=>1,'timeSettled'=>time()];
                        $updateBalance = UserBalances::where('id',$userBalance->id)->update($dataBalance);
                        if (!empty($updateBalance)){
                            AccountFunding::where('id',$accountFunding->id)->update($dataAccountFunding);
                            $details = 'Your pending <b>'.$accountFunding->currency.' '.number_format($transaction->amountCredit,2).'</b>
                                    has been settled into your account and available for use. Please contact support if you have any further enquiries.';
                            event(new SendNotification($user, $details, '3'));
                        }
                    }else{
                        $details = $this->sendErrorMail($accountFunding, $transaction, $userBalance, $user);
                    }
                }else{
                    $details = $this->sendErrorMail($accountFunding, $transaction, $userBalance, $user);
                }
            }
        }
    }

    /**
     * @param $accountFunding
     * @param $transaction
     * @param $userBalance
     * @param $user
     * @return string
     */
    public function sendErrorMail($accountFunding, $transaction, $userBalance, $user): string
    {
        $details = 'While trying to settle your pending <b>' . $accountFunding->currency . ' ' . number_format($transaction->amountCredit, 2) . '</b> ,
                    it was discovered that your account threshold of <b>' . $userBalance->currency . ' ' . number_format($userBalance->TransactionLimit, 2) . '</b>
                    transaction limit and <b>' . $userBalance->currency . ' ' . number_format($userBalance->AccountLimit, 2) . '</b> account limit
                    is below the expected amount. Please contact our support centre for more information regarding this, and how to upgrade your account.';
        event(new SendNotification($user, $details, '3'));
        return 'done';

    }
}
