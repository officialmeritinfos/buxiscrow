<?php

namespace App\Console\Commands;

use App\Custom\RandomString;
use App\Events\EscrowNotification;
use App\Models\Charges;
use App\Models\EscrowApprovals;
use App\Models\EscrowPayments;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\MerchantIncome;
use App\Models\Settlements;
use App\Models\User;
use App\Models\UserBalances;
use App\Models\UserReferrals;
use Illuminate\Console\Command;

class CreditMerchant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:merchant';

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
        $generalSettings = GeneralSettings::where('id',1)->first();
        //get escrow
        $escrows = Escrows::where('status',4)->get();
        if ($escrows->count()>0){
            foreach ($escrows as $escrow) {
                $merchant = User::where('id',$escrow->merchant)->first();
                $payer = User::where('id',$escrow->user)->first();
                $code = new RandomString('9');
                $merchantBalance = MerchantBalances::where('currency',$escrow->currency)->where('merchant',$merchant->id)->first();
                //get escrow Approvals
                $approveCount = 0;
                $escrowApproval = EscrowApprovals::where('escrowId',$escrow->id)->first();
                if (!empty($escrowApproval)){
                    if ($escrowApproval->approvedByMerchant == 1){
                        $approveCount = $approveCount+1;
                    }
                    if ($escrowApproval->approvedByBuyer == 1){
                        $approveCount = $approveCount+1;
                    }
                    //since both parties have to approve first before delivering funds
                    if ($approveCount == 2){
                        $accountLimit = $merchantBalance->AccountLimit;
                        $transactionLimit = $merchantBalance->TransactionLimit;
                        //get escrow payment
                        $escrowPayment = EscrowPayments::where('escrowId',$escrow->id)->where('paymentStatus',1)->where('isSettled',2)->first();
                        if (!empty($escrowPayment)){
                            $newBalance = $merchantBalance->availableBalance + $escrowPayment->amountCredit;
                            $newPendingBalance = $merchantBalance->frozenBalance + $escrowPayment->amountCredit;
                            $dataEscrow = ['status'=>1];
                            $dataEscrowPayment = ['isSettled'=>1];
                            $dataMerchantIncomes = ['merchant'=>$merchant->id,'currency'=>$escrow->currency,'incomeRef'=>$code->randomStr(),
                                'charge'=>0,'isSettled'=>1,'amount'=>$escrowPayment->amountCredit];
                            //update info
                            $updateEscrow = Escrows::where('id',$escrow->id)->update($dataEscrow);
                            if ($updateEscrow){
                                if (($transactionLimit >= $escrowPayment->amountCredit) && ($newBalance <= $accountLimit)){
                                    $dataBalance = ['availableBalance'=>$newBalance];
                                    $dataSettlement = ['merchant'=>$merchant->id,'currency'=>$escrow->currency,'amount'=>$escrowPayment->amountCredit,
                                        'settlementRef'=>$code->randomAlpha().date('dmYhis').mt_rand(),'isSettled'=>2,'escrowId'=>$escrow->id,'escrowRef'=>$escrow->reference,
                                        'dateForSettlement'=>strtotime('tomorrow',time())];
                                    $detailToMerchant = 'The payment for your escrow with reference <b>'.$escrow->reference.'</b> has
                                    been <b>settled</b> into your account and is available for withdrawal. <br> Thanks for using '.config('app.name');
                                }else{
                                    $dataBalance = ['frozenBalance'=>$newPendingBalance];
                                    $dataSettlement = ['merchant'=>$merchant->id,'currency'=>$escrow->currency,'amount'=>$escrowPayment->amountCredit,
                                        'settlementRef'=>$code->randomAlpha().date('dmYhis').mt_rand(),'isSettled'=>2,'escrowId'=>$escrow->id,'escrowRef'=>$escrow->reference,
                                        'dateForSettlement'=>strtotime('tomorrow',time())];
                                    $detailToMerchant = 'The payment for your escrow with reference <b>'.$escrow->reference.'</b> has
                                    been <b>settled</b> into your pending account and is not available for withdrawal. Verify your account
                                    to increase this limit. If you have verified it nonetheless, write to request for an increase in account
                                    Limit.
                                     <br> Thanks for using '.config('app.name');
                                }
                                EscrowPayments::where('id',$escrowPayment->id)->update($dataEscrowPayment);
                                MerchantIncome::create($dataMerchantIncomes);
                                Settlements::create($dataSettlement);
                                MerchantBalances::where('id',$merchantBalance->id)->update($dataBalance);

                                $merchantRefs = $this->addReferralBonusMerchant($escrow,$merchant);
                                $payerRefs = $this->addReferralBonusPayer($escrow,$payer);

                                $charges = $merchantRefs['amount']+$payerRefs['amount'];
                                $dataCharges = ['amount'=>$escrowPayment->amountPaid,'charge'=>$escrow->charge,'flutCharge'=>$charges,
                                    'currency'=>$escrow->currency,'status'=>1,'reference'=>$escrow->reference,'transType'=>3];
                                Charges::create($dataCharges);
                                //send notification to merchant about the settlement
                                event(new EscrowNotification($merchant, $detailToMerchant, 'Escrow Payment Settlement'));

                                //send mail about the completion of the transactions
                                $dataMail = 'The escrow with reference <b>'.$escrow->reference.'</b> has been completed by both parties
                                 and completed. <br> Thanks for using <b>'.config('app.name').'</b>...your favorite marketplace for all
                                 transactions. If you are pleased with our service in creating a safe environment for buyers and sellers, please
                                 leave a review for us on <b>Trust Pilot using this link below:</b>
                                 <br><a href="'.$generalSettings->reviewLink.'" target="_blank">'.$generalSettings->reviewLink.'</a>' ;
                                event(new EscrowNotification($merchant, $dataMail, 'Escrow Transaction Completion'));
                                event(new EscrowNotification($payer, $dataMail, 'Escrow Transaction Completion'));
                            }
                        }
                    }
                }
            }
        }
    }
    public function addReferralBonusMerchant($escrow,$merchant){
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let us check if the merchant was referred by someone
        $merchantRef = $merchant->refBy;
        if (!empty($merchantRef)){
            $merchantHasRef =1;
            $referrer = User::where('username',$merchantRef)->first();
            $merchantRefBonus = $escrow->charge * ($generalSettings->referralBonus/100);
            switch ($referrer->accountType){
                case 1:
                    $referrerBalance = MerchantBalances::where('merchant',$referrer->id)->where('currency',$escrow->currency)->first();
                    $newMerchantRefBalance = $referrerBalance->referralBalance + $merchantRefBonus;
                    $dataMerchantReferralBalance = ['referralBalance'=>$newMerchantRefBalance];
                    MerchantBalances::where('id',$referrerBalance->id)->update($dataMerchantReferralBalance);
                case 2:
                    $referrerBalance = UserBalances::where('user',$referrer->id)->where('currency',$escrow->currency)->first();
                    $newMerchantRefBalance = $referrerBalance->referralBalance + $merchantRefBonus;
                    $dataMerchantReferralBalance = ['referralBalance'=>$newMerchantRefBalance];
                    UserBalances::where('id',$referrerBalance->id)->update($dataMerchantReferralBalance);
            }
            //add referral earning
            $dataReferralEarning =['user'=>$merchant->id,'referredBy'=>$referrer->id,'amount'=>$merchantRefBonus,'currency'=>$escrow->currency,'status'=>1];
            UserReferrals::create($dataReferralEarning);
            $dataRefMerchant = ['hasRef'=>$merchantHasRef,'amount'=>$merchantRefBonus];
            //send mail about bonus
            $dataMail = 'You have earned  <b>'.$escrow->currency.number_format($merchantRefBonus,2).'</b> as a bonus for
                        referring a friend to use '.config('app.name');
            event(new EscrowNotification($referrer, $dataMail, 'Referral Bonus'));
        }else{
            $merchantHasRef =2;
            $dataRefMerchant = ['hasRef'=>$merchantHasRef,'amount'=>0];
        }
        return $dataRefMerchant;
    }
    public function addReferralBonusPayer($escrow,$payer){
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let us check if the merchant was referred by someone
        $payerRef = $payer->refBy;
        if (!empty($payerRef)){
            $payerHasRef =1;
            $referrer = User::where('username',$payerRef)->first();
            $merchantRefBonus = $escrow->charge * ($generalSettings->referralBonus/100);
            switch ($referrer->accountType){
                case 1:
                    $referrerBalance = MerchantBalances::where('merchant',$referrer->id)->where('currency',$escrow->currency)->first();
                    $newMerchantRefBalance = $referrerBalance->referralBalance + $merchantRefBonus;
                    $dataMerchantReferralBalance = ['referralBalance'=>$newMerchantRefBalance];
                    MerchantBalances::where('id',$referrerBalance->id)->update($dataMerchantReferralBalance);
                case 2:
                    $referrerBalance = UserBalances::where('user',$referrer->id)->where('currency',$escrow->currency)->first();
                    $newMerchantRefBalance = $referrerBalance->referralBalance + $merchantRefBonus;
                    $dataMerchantReferralBalance = ['referralBalance'=>$newMerchantRefBalance];
                    UserBalances::where('id',$referrerBalance->id)->update($dataMerchantReferralBalance);
            }
            //add referral earning
            $dataReferralEarning =['user'=>$payer->id,'referredBy'=>$referrer->id,'amount'=>$merchantRefBonus,'currency'=>$escrow->currency,'status'=>1];
            UserReferrals::create($dataReferralEarning);
            $dataRefPayer = ['hasRef'=>$payerHasRef,'amount'=>$merchantRefBonus];
            //send mail about bonus
            $dataMail = 'You have earned  <b>'.$escrow->currency.number_format($merchantRefBonus,2).'</b> as a bonus for
                        referring a friend to use '.config('app.name');
            event(new EscrowNotification($referrer, $dataMail, 'Referral Bonus'));
        }else{
            $payerHasRef =2;
            $dataRefPayer = ['hasRef'=>$payerHasRef,'amount'=>0];
        }
        return $dataRefPayer;
    }
}
