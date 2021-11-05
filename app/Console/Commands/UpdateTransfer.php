<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Models\Charges;
use App\Models\Payouts;
use App\Models\Transactions;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Transfer Status';

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
        $transactions = Transactions::where('status',2)->where('transactionType',2)->get();
        if ($transactions->count()>0){
            foreach ($transactions as $transaction) {
                //get user
                $user= User::where('id',$transaction->user)->first();
                $transId = $transaction->transId;
                $gateway = new FlutterWave();
                $transfers = $gateway->getTransferId($transId);
                //get a specific withdrawal
                $withdrawal = Payouts::where('user',$user->id)->where('reference',$transaction->transactionRef)->first();
                if ($transfers->ok()){
                    $trans = $transfers->json();
                    $withdrawalStatus = $trans['data']['status'];
                    if (strtolower($withdrawalStatus)=='successful'){
                        $dataTransaction = ['paymentStatus'=>1,'status'=>1];
                        $dataCharge = ['status'=>1];
                        $dataWithdrawal = [
                            'status'=>1,'isCompleted'=>1,'completedMessage'=>$trans['data']['complete_message'],
                            'bank'=>$trans['data']['bank_name'] , 'bankCode'=>$trans['data']['bank_code'],
                            'accountName'=>$trans['data']['full_name'], 'accountNumber'=>$trans['data']['account_number'],
                            'narration'=>$trans['data']['narration']
                        ];
                        //update record
                        $updateTransaction = Transactions::where('id',$transaction->id)->update($dataTransaction);
                        if (!empty($updateTransaction)){
                            Payouts::where('id',$withdrawal->id)->update($dataWithdrawal);
                            Charges::where('reference',$transaction->transactionRef)->update($dataCharge);
                            $details = 'We have completed your transfer of <b>'.$trans['data']['currency'].'</b> <b>'.number_format($trans['data']['amount'],2).'</b>
                                        to <b>'.$trans['data']['full_name'].'</b> of <b>'.$trans['data']['bank_name'].'</b> and account number
                                        <b>'.$trans['data']['account_number'].'.</b>' ;
                            $dataActivity = ['user' => $user->id, 'activity' => 'Transfer completion', 'details' => $details, 'agent_ip' => ''];
                            event(new AccountActivity($user, $dataActivity));
                            event(new SendNotification($user, $details, '3'));
                        }
                    }elseif (strtolower($withdrawalStatus)=='failed'){
                        //get balance
                        $balance = UserBalances::where('user',$user->id)->where('currency',$transaction->currency)->first();
                        $newBalance = $balance->availableBalance+$transaction->amountCharged;
                        $dataTransaction = ['paymentStatus'=>3,'status'=>3];
                        $dataCharge = ['status'=>3];
                        $dataBalance = ['availableBalance'=>$newBalance];
                        $dataWithdrawal = [
                            'status'=>3,'isCompleted'=>1,'completedMessage'=>$trans['data']['complete_message'],
                            'bank'=>$trans['data']['bank_name'] , 'bankCode'=>$trans['data']['bank_code'],
                            'accountName'=>$trans['data']['full_name'], 'accountNumber'=>$trans['data']['account_number'],
                            'narration'=>$trans['data']['narration']
                        ];
                        //update record
                        $updateTransaction = Transactions::where('id',$transaction->id)->update($dataTransaction);
                        if (!empty($updateTransaction)){
                            Payouts::where('id',$withdrawal->id)->update($dataWithdrawal);
                            Charges::where('reference',$transaction->transactionRef)->update($dataCharge);
                            UserBalances::where('id',$balance->id)->update($dataBalance);
                            $details = 'We were unable have completed your transfer of <b>'.$trans['data']['currency'].'</b> <b>'.number_format($trans['data']['amount'],2).'</b>
                                        to <b>'.$trans['data']['full_name'].'</b> of <b>'.$trans['data']['bank_name'].'</b> and account number
                                        <b>'.$trans['data']['account_number'].'.</b> because of '.$trans['data']['complete_message'];
                            $dataActivity = ['user' => $user->id, 'activity' => 'Transfer Failed', 'details' => $details, 'agent_ip' => ''];
                            event(new AccountActivity($user, $dataActivity));
                            event(new SendNotification($user, $details, '3'));
                        }

                    }elseif (strtolower($withdrawalStatus)=='pending'){
                        $dataWithdrawal = [
                            'completedMessage'=>$trans['data']['complete_message'],
                            'bank'=>$trans['data']['bank_name'] , 'bankCode'=>$trans['data']['bank_code'],
                            'accountName'=>$trans['data']['full_name'], 'accountNumber'=>$trans['data']['account_number'],
                            'narration'=>$trans['data']['narration']
                        ];
                        Payouts::where('id',$withdrawal->id)->update($dataWithdrawal);
                    }
                }else{
                    $trans = $transfers->json();
                }
            }
        }
    }
}
