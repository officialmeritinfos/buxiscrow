<?php

namespace App\Console\Commands;

use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Models\Businesses;
use App\Models\EscrowPayments;
use App\Models\Escrows;
use App\Models\User;
use Illuminate\Console\Command;

class EscrowExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'escrow:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'When an Escrow expires, and no payment was received.';

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
       $escrows = Escrows::where('status',2)->where('deadline','<',$moment) ->get();
       if ($escrows->count()>0){
           foreach ($escrows as $escrow) {
               $reference = $escrow->reference;
               $payer = User::where('id',$escrow->user)->first();
               $merchant = User::where('id',$escrow->merchant)->first();
               $business = Businesses::where('id',$escrow->business)->first();
               $hasPayment = EscrowPayments::where('paymentStatus',1)->where('escrowId',$escrow->id)->first();
               if (empty($hasPayment)){
                   $dataEscrow = ['status'=>3];
                   $update = Escrows::where('id',$escrow->id)->update($dataEscrow);
                   if (!empty($update)){
                       //send notification to payer
                       //Send Notification to Payer
                       $detailsToPayer = 'After not receiving your payment for the escrow transaction <b>'.$reference.'</b>,
                        created for you by <b>'.$business->name.'</b>, this transaction is hereby cancelled. Reach out to
                        your seller for a new transaction.' ;
                       $dataActivityUser = ['user' => $payer->id, 'activity' => 'Escrow Expires', 'details' => $detailsToPayer,
                           'agent_ip' => ''];
                       event(new AccountActivity($payer, $dataActivityUser));
                       event(new EscrowNotification($payer, $detailsToPayer, 'Expired Escrow Transaction'));

                       //Send Notification To merchant
                       $detailsToMerchant = 'Your escrow transaction with reference <b>'.$reference.'</b> has timed out without
                        us receiving any payment for it.' ;
                       $dataActivityMerchant = ['merchant' => $merchant->id, 'activity' => 'Escrow Expired', 'details' => $detailsToMerchant,
                           'agent_ip' => ''];
                       event(new AccountActivity($merchant, $dataActivityMerchant));
                       event(new EscrowNotification($merchant, $detailsToMerchant, 'Expired Escrow'));
                   }
               }
           }
       }
    }
}
