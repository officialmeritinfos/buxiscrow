<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Businesses;
use App\Models\Cities;
use App\Models\Country;
use App\Models\CurrencyAccepted;
use App\Models\DeliveryLocations;
use App\Models\DeliveryService;
use App\Models\EscrowDeliveries;
use App\Models\EscrowPayments;
use App\Models\EscrowReports;
use App\Models\GeneralSettings;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Escrows;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Escrow extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $escrows = Escrows::where('merchant',$user->id)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Escrow Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'escrows'=>$escrows
        ];
        return view('dashboard.merchant.escrows',$dataView);
    }
    public function createEscrow(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $businesses = Businesses::where('merchant',$user->id)->where('status',1)->get();
        $currencies = CurrencyAccepted::where('status',1)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'New Escrow Transaction','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses,'currencies'=>$currencies
        ];
        return view('dashboard.merchant.create_escrows',$dataView);
    }
    public function getCurrencyChargeInternal($currency){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $currency = CurrencyAccepted::where('code',strtoupper($currency))->first();
        if (!empty($currency)){
            $success['charge'] = $currency->internalCharge;
            $success['base_charge'] = $currency->baseCharge;
            $success['min_charge'] = $currency->minCharge;
            $success['max_charge'] = $currency->maxCharge;
            return $this->sendResponse($success, 'Fetched');
        }
        return $this->sendError('Retrieveal Error ', ['error' => 'No data found'], '422', 'Failed');
    }
    public function doCreation(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            [
                'title' => ['bail','required','string'], 'currency' => ['bail','required','alpha'], 'amount' => ['bail','required','numeric'],
                'who_pays_charge' => ['bail','required','numeric','integer'], 'charge_paid_by_merchant' => ['bail','nullable','numeric'],
                'charge_paid_by_buyer' => ['bail','nullable','numeric'], 'description' => ['bail','required','string'],
                'store' => ['bail','required','numeric','integer',
                    Rule::exists('business','id')->where(function ($query) {
                        return $query->where('status', 1);
                    }),
                    ],
                'email' => ['bail','required','email',
                    Rule::exists('users','email')->where(function ($query) {
                        return $query->where('status', 1)->where('accountType',2);
                    }),
                    ],
                'deadline' => ['bail','required','date','after:today'],
                'inspection' => ['bail','required','date','after:deadline'],
            ],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Account Pin',]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $input = $request->input();
        /**
         * Run some validations and check if the data submitted is valid
         * Get the user that is to pay
         * Check if the business belongs to the merchant
         * Get the currency for charge
         */
        $payer = User::where('email',$input['email'])->first();
        $business = Businesses::where('id',$input['store'])->where('merchant',$user->id)->first();
        $currency = CurrencyAccepted::where('code',$input['currency'])->first();
        if (empty($business)){
            return $this->sendError('Creation Error ', ['error' => 'Invalid store'],
                '422', 'Failed');
        }
        if ($business->isCrypto ==1 && $currency->code !='USD'){
            return $this->sendError('Creation Error ', ['error' => 'All cryptocurrency transactions must be in USD. Your selected store
            is a cryptocurrency based business.'],
                '422', 'Failed');
        }
        $percentCharge = $currency->internalCharge;
        $minCharge = $currency->minCharge;
        $maxCharge = $currency->maxCharge;
        $amountCharged = $input['amount']*($percentCharge/100);
        if ($amountCharged < $minCharge){
            $amountCharged = $minCharge;
        }elseif ($amountCharged > $maxCharge){
            $amountCharged = $maxCharge;
        }else{
            $amountCharged = $amountCharged;
        }
        /**
         * Check the charging type selected
         * 1 - meerchant pays
         * 2 - Buyer pays
         * 3 - Both pays
         */
        $chargeType = $input['who_pays_charge'];
        switch ($chargeType){
            case 1:
                $amountToPay = $input['amount'];
                $amountSettle = $amountToPay-$amountCharged;
                $percentMerchant = 0;
                $percentBuyer = 0;
                break;
            case 2:
                $amountToPay = $input['amount']+$amountCharged;
                $amountSettle = $input['amount'];
                $percentMerchant = 0;
                $percentBuyer = 0;
                break;
            default:
                $percentMerchant = $amountCharged*($input['charge_paid_by_merchant']/100);
                $percentBuyer = $amountCharged*($input['charge_paid_by_buyer']/100);
                $amountSettle = $input['amount']-$percentMerchant;
                $amountToPay = $input['amount']+$percentBuyer;
        }
        $reference = Str::random('4').date('dmYhis').mt_rand();
        $dataEscrow = [
            'merchant'=>$user->id, 'business'=>$business->id, 'user'=>$payer->id, 'reference'=>$reference,
            'amount'=>$input['amount'], 'amountToPay'=>$amountToPay, 'percentCharge'=>$percentCharge,
            'charge'=>$amountCharged, 'whoPaysCharge'=>$input['who_pays_charge'], 'percentChargePaidByUser'=>$input['charge_paid_by_buyer'],
            'percentChargePaidByMerchant'=>$input['charge_paid_by_merchant'], 'chargePaidBySeller'=>$percentMerchant,
            'chargePaidByBuyer'=>$percentBuyer, 'title'=>$input['title'], 'description'=>$input['description'],
            'escrowType'=>1, 'transactionType'=>3, 'isCrypto'=>$business->isCrypto, 'currency'=>$input['currency'],
            'deadline'=>strtotime($input['deadline']), 'inspectionPeriod'=>strtotime($input['inspection'])
        ];
        $add = Escrows::create($dataEscrow);
        if (!empty($add)){
            //Send Notification to Payer
            $detailsToPayer = 'A new escrow with reference <b>'.$reference.'</b> has been created for you by
            <b>'.$business->name.'.</b> Login to your account to view more details and proceed to making payments.' ;
            $dataActivityUser = ['user' => $payer->id, 'activity' => 'New Pending Escrow', 'details' => $detailsToPayer,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($payer, $dataActivityUser));
            event(new EscrowNotification($payer, $detailsToPayer, 'New Pending Escrow Transaction'));

            //Send Notification To merchant
            $detailsToMerchant = 'A new escrow with reference <b>'.$reference.'</b> has been created by your store
            <b>'.$business->name.'</b> for '.$payer->name.'. Login to your account to view more details.' ;
            $dataActivityMerchant = ['merchant' => $user->id, 'activity' => 'New Escrow Transaction', 'details' => $detailsToMerchant,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivityMerchant));
            event(new EscrowNotification($user, $detailsToMerchant, 'New Escrow Transaction'));

            $success['created']=true;
            return $this->sendResponse($success, 'Escrow created');
        }
        return $this->sendError('Creation Error',['error'=>'An error occurred while creating this escrow'],
            '422','Creation Failed');
    }
    public function details($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $escrow = Escrows::where('merchant',$user->id)->where('reference',$ref)->first();
        if (empty($escrow)){
            return back()->with('error','Escrow not found or you no clearance to view this page.');
        }
        $business = Businesses::where('id',$escrow->business)->where('merchant',$escrow->merchant)->first();
        $payment = EscrowPayments::where('escrowId',$escrow->id)->where('merchant',$escrow->merchant)->first();
        $reports = EscrowReports::where('escrow_id',$escrow->id)->where('merchant',$escrow->merchant)->first();
        $payer = User::where('id',$escrow->user)->first();
        $escrow_delivery = EscrowDeliveries::where('escrowId',$escrow->id)->first();
        $logisticsLocation = DeliveryLocations::where('id',$escrow->logistics)->first();
        if (!empty($logisticsLocation)){
            $logisticCompany = DeliveryService::where('id',$logisticsLocation->logisticsId)->first();
        }else{
            $logisticCompany = '';
        }
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Escrow Details','slogan'=>'- Making safer transactions','user'=>$user,
            'escrow'=>$escrow,'business'=>$business,'payment'=>$payment,'report'=>$reports,'payer'=>$payer,'escrow_delivery'=>$escrow_delivery,
            'logisticsLocation'=>$logisticsLocation,'logistics'=>$logisticCompany
        ];
        return view('dashboard.merchant.escrow_details',$dataView);
    }
    public function notifyPayerAboutPendingPayments($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $reference = $ref;
        $user=Auth::user();
        $escrow = Escrows::where('merchant',$user->id)->where('reference',$ref)->first();
        if (empty($escrow)){
            return $this->sendError('Retrieval Error ', ['error' => 'No data found'], '422', 'Failed');
        }
        $payer = User::where('id',$escrow->user)->first();
        $business = Businesses::where('id',$escrow->business)->first();
        if (!empty($payer)){
            //Send Notification to Payer
            $detailsToPayer = 'You have not paid for the escrow with reference <b>'.$reference.'</b> which was created for you by
            <b>'.$business->name.'.</b> Ensure you make your payment before <b>'.date('d-m-Y h:i:s a',$escrow->deadline).'</b> to help
            the merchant/vendor deliver your goods on time.' ;
            event(new EscrowNotification($payer, $detailsToPayer, 'Payment Reminder: Pending Escrow Payment'));

            $success['notified']=true;
            return $this->sendResponse($success, 'Reminder sent');
        }
        return $this->sendError('Notification Error', ['error' => 'Unable to send notification'], '422', 'Failed');
    }
    public function doLogistics(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            [
                'ref' => ['bail','required','string'],
                'address' => ['bail','required','string'],
                'country' => ['bail','required','alpha'],
                'state' => ['bail','required','numeric','integer'],
                'city' => ['bail','required','string'],
                'service' => ['bail','required','numeric','integer'],
            ],
            ['required'  =>':attribute is required'],
            ['services'   =>'Logistic Company',]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $input = $request->input();
        //get the escrow
        $escrow = Escrows::where('reference',$input['ref'])->where('merchant',$user->id)->first();
        if (empty($escrow)){
            return $this->sendError('Escrow Error',['error'=>'Escrow not found'],
                '422','Update Failed');
        }
        $logisticsLocation = DeliveryLocations::where('id',$input['service'])->first();
        if (empty($logisticsLocation)){
            return $this->sendError('Creation Error',['error'=>'Region not supported'],
                '422','Update Failed');
        }
        $logistics = DeliveryService::where('id',$logisticsLocation->logisticsId)->first();
        if (empty($logistics)){
            return $this->sendError('Creation Error',['error'=>'No such delivery is found'],
                '422','Update Failed');
        }
        $country = Country::where('iso2',$input['country'])->first();
        $state = States::where('id',$input['state'])->first();
        $city = Cities::where('name',$input['city'])->first();

        $payer = User::where('id',$escrow->user)->first();
        $reference = $input['ref'];
        $business = Businesses::where('id',$escrow->business)->first();
        $dataDelivery = [
            'business'=>$escrow->business,
            'merchant'=>$user->id,
            'escrowId'=>$escrow->id,
            'logistics'=>$logisticsLocation->id,
            'logisticsName'=>$logistics->name,
            'amount'=>$logisticsLocation->Charge,
            'currency'=>$logisticsLocation->currency,
            'country'=>$country->name,
            'state'=>$state->name,
            'city'=>$city->name,
            'address'=>$input['address']
        ];
        $dataEscrow = [
            'useDelivery'=>1,
            'deliveryAmount'=>$logisticsLocation->Charge,
            'logistics'=>$logistics->id,
            'deliveryCurrency'=>$logisticsLocation->currency,
        ];
        $add = EscrowDeliveries::create($dataDelivery);
        if (!empty($add)){
            Escrows::where('id',$escrow->id)->update($dataEscrow);
            //Send Notification to Payer
            $detailsToPayer = 'A delivery service has been added for the escrow with reference <b>'.$reference.'</b> which was created for you by
            <b>'.$business->name.'.</b> You will receive a notification soon about your product/goods.' ;
            $dataActivityUser = ['user' => $payer->id, 'activity' => 'Escrow Delivery Service', 'details' => $detailsToPayer,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($payer, $dataActivityUser));
            event(new EscrowNotification($payer, $detailsToPayer, 'New Delivery Service For Escrow Transaction'));

            //Send Notification To merchant
            $detailsToMerchant = 'Delivery service was added to escrow transaction with reference <b>'.$reference.'</b>.' ;
            $dataActivityMerchant = ['merchant' => $user->id, 'activity' => 'Delivery Service', 'details' => $detailsToMerchant,
                'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivityMerchant));

            $success['created']=true;
            return $this->sendResponse($success, 'Delivery service add');
        }
        return $this->sendError('Creation Error',['error'=>'Error add delivery service'],
            '422','Update Failed');
    }
}
