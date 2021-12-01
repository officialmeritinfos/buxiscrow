<?php

namespace App\Console\Commands;

use App\Events\EscrowNotification;
use App\Models\MerchantBalances;
use App\Models\Settlements;
use App\Models\User;
use Illuminate\Console\Command;

class SettleEscrowPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settleEscrow:payments';

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
        //get pending settlements
        $settlements = Settlements::where('isSettled','!=',1)->where('dateForSettlement','<=',$moment)->get();
        if ($settlements->count()>0){
            foreach ($settlements as $settlement) {
                $settlementRef = $settlement->settlementRef;
                //get the merchant and his balances as well as the escrow
                $merchant = User::where('id',$settlement->merchant)->first();
                $balance = MerchantBalances::where('merchant',$merchant->id)->where('currency',$settlement->currency)->first();
                //since this amount is stored in the pending balance, we need to debit it
                $availableBalance = $balance->availableBalance;
                $pendingBalance = $balance->frozenBalance;
                $newAvailableBalance = $availableBalance + $settlement->amount;
                $newPendingBalance = $pendingBalance - $settlement->amount;
                //check if the account limit and transaction limit is up to
                if (($balance->TransactionLimit > $settlement->amount) && ($balance->AccountLimit > $newAvailableBalance )){
                    $dataBalance = ['availableBalance'=>$newAvailableBalance,'frozenBalance'=>$newPendingBalance];
                    $dataSettlement = ['isSettled'=>1];
                    $hasSettled = 1;
                }else{
                    $dataBalance = ['availableBalance'=>$balance->availableBalance,'frozenBalance'=>$balance->frozenBalance];
                    $dataSettlement = ['isSettled'=>2,'dateForSettlement'=>strtotime('tomorrow',time())];
                    $hasSettled = 2;
                }
                //update data
                $updateBalance = MerchantBalances::where('id',$balance->id)->update($dataBalance);
                if ($updateBalance){
                    Settlements::where('id',$settlement->id)->update($dataSettlement);
                    if ($hasSettled == 1){
                        $detailToMerchant = 'The payment for your escrow with reference <b>'.$settlement->escrowRef.'</b> has
                        been <b>settled</b> into your account and is available for withdrawal. <br> Thanks for using '.config('app.name');
                    } else{
                        $detailToMerchant = 'We attempted settling your available funds for the escrow with reference <b>'.$settlement->escrowRef.'</b>
                        into your available balance but seems like your account limit will be exceeded. Please reach out to support for help in rectifying this
                        <br> Thanks for using '.config('app.name');
                    }
                    //send notification to merchant about the settlement
                    event(new EscrowNotification($merchant, $detailToMerchant, 'Escrow Payment Settlement'));
                }
            }
        }
    }
}
