<?php

namespace App\Console\Commands;

use App\Custom\RandomString;
use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Models\Businesses;
use App\Models\EscrowPayments;
use App\Models\Escrows;
use App\Models\Refunds;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Console\Command;

class RefundEscrow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refund:escrow';

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
        //get escrows
        $escrows = Escrows::where('status',3)->get();
        if ($escrows->count()>0){
            foreach ($escrows as $escrow) {
                $payer = User::where('id',$escrow->user)->first();
                $merchant = User::where('id',$escrow->merchant)->first();
                $code = new RandomString(3);
                $business = Businesses::where('id',$escrow->business)->first();
                //check if the escrow has a payment
                $escrowPayments = EscrowPayments::where('escrowId',$escrow->id)->where('isQueuedForRefund',1)->first();
                if (!empty($escrowPayments)){
                    if ($escrowPayments->isRefunded !=1){
                        $payerBalance = UserBalances::where('user',$payer->id)->where('currency',strtoupper($escrow->currency))->first();
                        $newBalance = $payerBalance->availableBalance + $escrowPayments->amountPaid;
                        //set the data
                        $dataBalance = ['availableBalance'=>$newBalance];
                        $dataRefund = ['isRefunded'=>1];
                        $dataRefunds = ['merchant'=>$escrow->merchant,'user'=>$escrow->user,'business'=>$escrow->business,
                            'isEscrow'=>1,'refundRef'=>$code->randomAlpha().date('dmYhis'),'amount'=>$escrowPayments->amountPaid,
                            'isRefunded'=>1];
                        //update user balance and the Payment
                        $updatePayment = EscrowPayments::where('id',$escrowPayments->id)->update($dataRefund);
                        if ($updatePayment){
                            UserBalances::where('id',$payerBalance->id)->update($dataBalance);
                            Refunds::create($dataRefunds);
                            //send notification to Payer about the refund
                            $detailsToPayer = 'Your escrow with reference <b>'.$escrow->reference.'</b> which was created for you by
                                <b>'.$business->name.'</b> has been <b>refunded</b> by the seller. Remember that we are always available
                                to help make your transaction safer.' ;
                            event(new EscrowNotification($payer, $detailsToPayer, 'Escrow Payment Refund'));
                        }
                    }
                }
            }
        }
    }
}
