<?php

namespace App\Http\Controllers\Web\User;

use App\Custom\RandomString;
use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AccountFunding;
use App\Models\Businesses;
use App\Models\DeliveryLocations;
use App\Models\DeliveryService;
use App\Models\EscrowApprovals;
use App\Models\EscrowDeliveries;
use App\Models\EscrowPayments;
use App\Models\EscrowReports;
use App\Models\Escrows as escrowsTransactions;
use App\Models\GeneralSettings;
use App\Models\ReportType;
use App\Models\User;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Escrows extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $escrows = escrowsTransactions::where('user',$user->id)->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Escrow Transactions', 'slogan' => '- Making safer transactions',
            'user' => $user,'escrows'=>$escrows,];
        return view('dashboard.user.escrows', $dataView);
    }
    public function details($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $escrow = \App\Models\Escrows::where('user',$user->id)->where('reference',$ref)->first();
        if (empty($escrow)){
            return back()->with('error','Escrow not found or you no clearance to view this page.');
        }
        $business = Businesses::where('id',$escrow->business)->where('merchant',$escrow->merchant)->first();
        $payment = EscrowPayments::where('escrowId',$escrow->id)->where('user',$escrow->user)->first();
        $reports = EscrowReports::where('escrow_id',$escrow->id)->where('user',$escrow->user)->first();
        $payer = User::where('id',$escrow->user)->first();
        $escrow_delivery = EscrowDeliveries::where('escrowId',$escrow->id)->first();
        $logisticsLocation = DeliveryLocations::where('id',$escrow->logistics)->first();
        if (!empty($logisticsLocation)){
            $logisticCompany = DeliveryService::where('id',$logisticsLocation->logisticsId)->first();
        }else{
            $logisticCompany = '';
        }
        $escrow_approvals = EscrowApprovals::where('escrowId',$escrow->id)->where('escrowRef',$escrow->reference)->first();
        $report_types = ReportType::where('status',1)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Escrow Details','slogan'=>'- Making safer transactions','user'=>$user,
            'escrow'=>$escrow,'business'=>$business,'payment'=>$payment,'report'=>$reports,'payer'=>$payer,'escrow_delivery'=>$escrow_delivery,
            'logisticsLocation'=>$logisticsLocation,'logistics'=>$logisticCompany,'approval'=>$escrow_approvals,
            'report_types'=>$report_types
        ];
        return view('dashboard.user.escrow_details',$dataView);
    }
    public function doPayment(Request $request, $ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $reference = $ref;
        $user=Auth::user();
        $escrow = \App\Models\Escrows::where('user',$user->id)->where('reference',$ref)->first();
        if (empty($escrow)){
            return $this->sendError('Retrieval Error ', ['error' => 'No data found'],
                '422', 'Failed');
        }
        //check if payment has been made already
        $paymentExists = EscrowPayments::where('escrowRef',$ref)->where('user',$user->id)->where('paymentStatus',1)->first();
        if (!empty($paymentExists)){
            return $this->sendError('Payment Error ', ['error' => 'Payment already made for this transaction.'],
                '422', 'Failed');
        }
        $merchant = User::where('id',$escrow->merchant)->first();
        //get the escrow payment details
        $code = new RandomString(4);
        $amountToPay = $escrow->amountToPay;
        $charge = $escrow->charge;
        $amountToCredit = $amountToPay-$charge;
        $currency = $escrow->currency;
        $paymentRef = $code->randomStr().date('dmYhis');
        //check if the user has enough amount
        $payerBalance = UserBalances::where('user',$user->id)->where('currency','=',strtoupper($currency))->first();
        if ($payerBalance->availableBalance < $amountToPay){
            return $this->sendError('Payment Error ', ['error' => 'Insufficient fund in '.$currency.' balance.
            Please fund your account and try again.'],
                '422', 'Failed');
        }
        $newBalance = $payerBalance->availableBalance - $amountToPay;
        $dataBalance = ['availableBalance'=>$newBalance];
        $dataEscrowPayment = [
            'escrowId'=>$escrow->id,
            'escrowRef'=>$reference,
            'transactionRef'=>$paymentRef,
            'transactionId'=>$code->randomNum().mt_rand(),
            'amountPaid'=>$amountToPay,
            'amountCredit'=>$amountToCredit,
            'currency'=>$currency,
            'paidThrough'=>'Wallet',
            'paymentStatus'=>1,
            'user'=>$user->id,
            'merchant'=>$escrow->merchant,
            'business'=>$escrow->business,
            'datePaid'=>time(),
        ];
        $dataEscrow =['status'=>4];

        $addPayment = EscrowPayments::create($dataEscrowPayment);
        if (!empty($addPayment)){
            escrowsTransactions::where('id',$escrow->id)->update($dataEscrow);
            UserBalances::where('id',$payerBalance->id)->update($dataBalance);
            //add activity for user
            $details = 'Your account was debited of <b>'.$currency.number_format($amountToPay,2).'</b> for
                    the payment of the transaction with reference <b>'.$reference.'</b>';
            $dataActivityUser = ['user' => $user->id, 'activity' => 'Escrow Transaction Paid', 'details' => $details,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivityUser));
            //Send Notification to Merchant
            $detailsToMerchant = 'The escrow transaction with reference <b>' . $reference . '</b> has been paid for by your client.
                Endeavour to deliver and update your delivery before the deadline :
                <b>' . date('d-m-Y h:i:s a', $escrow->deadline) . '</b> to help your client inspect your delivery on time.
                If you have any Questions, please contact your client or reach out to us at <b>'.$generalSettings->legalMail.'</b> for help.';
            event(new EscrowNotification($merchant, $detailsToMerchant, 'Payment made for Escrow'));
            $success['paid'] = true;
            return $this->sendResponse($success, 'Payment successful');
        }
        return $this->sendError('Notification Error', ['error' => 'Unable to send notification'], '422', 'Failed');
    }
    public function doComplete(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            [
                'ref' => ['bail','required','string'],
                'pin' => ['bail','required','string'],
            ],
            ['required'  =>':attribute is required'],
            ['ref'   =>'Reference','pin'=>'Transaction Pin']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $input = $request->input();

        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed){
            return $this->sendError('Validation Error',['error'=>'Invalid Account Pin. Please try again or contact support'],
                '422','Validation Failed');
        }
        //get the escrow
        $escrow = \App\Models\Escrows::where('reference',$input['ref'])->where('user',$user->id)->first();
        if (empty($escrow)){
            return $this->sendError('Escrow Error',['error'=>'Escrow not found'],
                '422','Update Failed');
        }
        if ($escrow->status == 3){
            return $this->sendError('Escrow Error',['error'=>'Escrow already cancelled'],
                '422','Update Failed');
        }
        if ($escrow->status == 1){
            return $this->sendError('Escrow Error',['error'=>'Escrow already completed'],
                '422','Update Failed');
        }
        if ($escrow->deadline < time()){
            return $this->sendError('Escrow Error',['error'=>'Escrow already completed'],
                '422','Update Failed');
        }
        //check if the transaction has a report against it
        $escrowHasReport = EscrowReports::where('escrow_id',$escrow->id)->where('resolved','!=',1)->first();
        if (!empty($escrowHasReport)){
            return $this->sendError('Escrow Error',['error'=>'There is a pending report on this transaction. Please hold on till
            this is resolved.'],
                '422','Update Failed');
        }
        //check if this transaction has been updated earlier
        $escrowWasApproved = EscrowApprovals::where('escrowId',$escrow->id)->first();
        if (empty($escrowWasApproved)){
            return $this->sendError('Escrow Error',['error'=>'You cannot perform this action first before your seller.
            Please contact your seller first.'],
                '422','Update Failed');
        }
        if ($escrowWasApproved->approvedByBuyer ==1){
            return $this->sendError('Escrow Error',['error'=>'You have already approved this transaction.'],
                '422','Update Failed');
        }
        $merchant = User::where('id',$escrow->merchant)->first();
        $reference = $input['ref'];
        $business = Businesses::where('id',$escrow->business)->first();
        //check if it has payment and queue for refund
        $payments = EscrowPayments::where('escrowId',$escrow->id)->first();
        if (empty($payments)){
            return $this->sendError('Escrow Error',['error'=>'Payment has not been received for this transaction yet.'],
                '422','Update Failed');
        }
        if ($payments->isRefunded == 1){
            return $this->sendError('Escrow Error',['error'=>'Payment for this transaction has been refunded.'],
                '422','Update Failed');
        }
        if ($payments->isQueuedForRefund == 1){
            return $this->sendError('Escrow Error',['error'=>'Payment for this transaction has been queued for a refund.'],
                '422','Update Failed');
        }
        if ($payments->isSettled == 1){
            return $this->sendError('Escrow Error',['error'=>'Payment for this transaction has been settled to your MERCHANT.'],
                '422','Update Failed');
        }
        $dataEscrow = ['status'=>4];
        $dataApproval = ['approvedByBuyer'=>1,'dateApprovedByBuyer'=>time()];

        $addApproval = EscrowApprovals::where('id',$escrowWasApproved->id)->update($dataApproval);
        if (!empty($addApproval)){
            $update = escrowsTransactions::where('id',$escrow->id)->update($dataEscrow);

            //Send Notification to Merchant
            $detailsToMerchant = 'Your escrow with reference <b>'.$reference.'</b> created by
            <b>'.$business->name.'</b>has been marked as <b>completed</b> by the buyer/seller. Consequently, the funds for this
            transaction will be available to you shortly.' ;
            event(new EscrowNotification($merchant, $detailsToMerchant, 'Escrow Transaction Approved'));

            //Add activity
            $details = 'Escrow transaction with reference <b>'.$reference.'</b> was marked as completed.' ;
            $dataActivityPayer = ['user' => $user->id, 'activity' => 'Escrow Approval', 'details' => $details,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivityPayer));

            $success['cancelled']=true;
            return $this->sendResponse($success, 'Transaction Marked as completed');
        }
        return $this->sendError('Creation Error',['error'=>'Error completing transaction'],
            '422','Update Failed');
    }
}
