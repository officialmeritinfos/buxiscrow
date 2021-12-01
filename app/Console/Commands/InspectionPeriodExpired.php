<?php

namespace App\Console\Commands;

use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Models\Businesses;
use App\Models\EscrowApprovals;
use App\Models\EscrowPayments;
use App\Models\Escrows;
use App\Models\User;
use Illuminate\Console\Command;

class InspectionPeriodExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspectionPeriod:expired';

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
        $escrows = Escrows::where('status',2)->where('inspectionPeriod','<',$moment) ->get();
        if ($escrows->count()>0){
            foreach ($escrows as $escrow) {
                $reference = $escrow->reference;
                $payer = User::where('id',$escrow->user)->first();
                $merchant = User::where('id',$escrow->merchant)->first();
                $business = Businesses::where('id',$escrow->business)->first();
                $hasPayment = EscrowPayments::where('paymentStatus',1)->where('escrowId',$escrow->id)->first();
                if (!empty($hasPayment)){
                    $hasPayerApproval = EscrowApprovals::where('escrowId',$escrow->id)->where('approvedByBuyer',1)->first();
                    if (empty($hasPayerApproval)){
                        $dataEscrow = ['status'=>4];
                        $dataApproval = ['approvedByBuyer'=>1,'dateApprovedByBuyer'=>time()];
                        $update = Escrows::where('id',$escrow->id)->update($dataEscrow);
                        if (!empty($update)){
                            EscrowApprovals::where('id',$hasPayment->id)->update($dataApproval);
                            //Send Notification to Payer
                            $detailsToPayer = 'After not receiving a report/approval for the escrow transaction <b>'.$reference.'</b>,
                            created for you by <b>'.$business->name.'</b>, this transaction is marked completed and available funds delivered to
                            your seller.' ;
                            $dataActivityUser = ['user' => $payer->id, 'activity' => 'Escrow Completed - Auto Client Approval', 'details' => $detailsToPayer,
                                'agent_ip' => ''];
                            event(new AccountActivity($payer, $dataActivityUser));
                            event(new EscrowNotification($payer, $detailsToPayer, 'Escrow Completed - Auto Client Approval'));

                            //Send Notification To merchant
                            $detailsToMerchant = 'Your escrow transaction with reference <b>'.$reference.'</b> has timed out without
                            us receiving any approval/report from your client for it and the funds received for it consequentially approved
                             for settlement into your account. Thanks for using '.config('app.name') ;
                            $dataActivityMerchant = ['merchant' => $merchant->id, 'activity' => 'Escrow Completed - Auto Client Approval', 'details' => $detailsToMerchant,
                                'agent_ip' => ''];
                            event(new AccountActivity($merchant, $dataActivityMerchant));
                            event(new EscrowNotification($merchant, $detailsToMerchant, 'Escrow Completed - Auto Client Approval'));
                        }
                    }
                }
            }
        }
    }
}
