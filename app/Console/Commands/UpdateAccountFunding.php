<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Models\AccountFunding;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UpdateAccountFunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:accountFunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Users Account Funding';

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
        $accountFundingTransactions = Transactions::where('status',2)->where('transactionType',1)->get();
        if ($accountFundingTransactions->count()>0) {
            foreach ($accountFundingTransactions as $transaction) {
                //get user
                $user= User::where('id',$transaction->user)->first();
                //get corresponding transaction
                $gateway = new FlutterWave();
                $transactions=$gateway->verifyTransactionId($transaction->transId);
                if ($transactions->ok()){
                    $trans = $transactions->json();
                    if ($trans['data']['status'] =='successful') {
                        $balance = UserBalances::where('user',$user->id)->where('currency',$transaction->currency)->first();
                        $new_balance = $transaction->amountCredit+$balance->frozenBalance;

                        $dataTransaction =['status'=>1,'paymentStatus'=>1,'datePaid'=>time()];
                        $dataBalance = ['frozenBalance'=>$new_balance];
                        $dataAccountFunding = ['user'=>$user->id,'amount'=>$transaction->amount,'currency'=>$transaction->currency,'fundingRef'=>$transaction->transactionRef,
                            'transactionId'=>$transaction->transId,'paymentMethod'=>$trans['data']['payment_type'],
                            'narration'=>$trans['data']['narration'],'datePaid'=>time(),'status'=>1,'timeSettle'=>strtotime('tomorrow')];
                        $updateTransaction = Transactions::where('id',$transaction->id)->update($dataTransaction);
                        $updateBalance = UserBalances::where('id',$balance->id)->update($dataBalance);
                        if (!empty($updateBalance) && !empty($updateTransaction)) {
                            AccountFunding::create($dataAccountFunding);
                            $details = 'Your ' . $balance->currency . ' Account Balance has been credited with <b>' . $balance->currency.'
                             ' . number_format($transaction->amountCredit,2) . '</b> from '.$transaction->title.'   at ' . date('d-m-Y h:i:s a') . '.
                             Your new account balance is <b>'.$balance->currency.' '.number_format($new_balance,2).'</b>' ;
                            $dataActivity = ['user' => $user->id, 'activity' => 'Account Balance Funding', 'details' => $details, 'agent_ip' => $trans['data']['ip']];
                            event(new AccountActivity($user, $dataActivity));
                            event(new SendNotification($user, $details, '3'));
                        }
                    }
                }
            }
        }
    }
}
