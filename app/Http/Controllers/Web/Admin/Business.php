<?php

namespace App\Http\Controllers\Web\Admin;

use App\Custom\CustomChecks;
use App\Custom\Regular;
use App\Events\AccountActivity;
use App\Events\EscrowNotification;
use App\Http\Controllers\Controller;
use App\Models\BusinessCustomers;
use App\Models\BusinessDocuments;
use App\Models\BusinessDocumentTypes;
use App\Models\Businesses;
use App\Models\BusinessType;
use App\Models\EscrowPayments;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\Refunds;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Business extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $businesses = Businesses::paginate(15);
        $dataView=['web'=>$generalSettings,'pageName'=>'Buinesses','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses];
        return view('dashboard.admin.businesses',$dataView);
    }
    public function businessDetail($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $regular = new Regular();
        $checks = new CustomChecks();
        $businessExists = Businesses::where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store not found or does not belong to you.');
        }
        $category = $checks::categoryVar($businessExists->category);
        $subcategory = $checks::subcategoryVar($businessExists->subcategory);
        $businessType = BusinessType::where('id',$businessExists->businessType)->first();
        $escrows = Escrows::where('business',$businessExists->id)->get();
        $customers = BusinessCustomers::where('business',$businessExists->id)->get();
        $refunds = Refunds::where('business',$businessExists->id)->get();
        $escrowPayments = EscrowPayments::where('business',$businessExists->id)->where('currency','NGN')
            ->where('paymentStatus',1)->sum('amountPaid');
        $escrowPaymentsUSD = EscrowPayments::where('business',$businessExists->id)->where('currency','USD')
            ->where('paymentStatus',1)->sum('amountPaid');
        $escrowPaymentsPending = EscrowPayments::where('business',$businessExists->id)->where('paymentStatus','!=', 1)
            ->where('currency','NGN')
            ->sum('amountPaid');
        $escrowPaymentsPendingUSD = EscrowPayments::where('business',$businessExists->id)
            ->where('currency','USD')
            ->where('paymentStatus','!=', 1)->sum('amountPaid');
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Store Data','slogan'=>'- Making safer transactions','user'=>$user,
            'business'=>$businessExists,'type'=>$businessType,'category'=>$category,'subcategory'=>$subcategory,
            'escrows'=>$escrows,'customers'=>$customers,'refunds'=>$refunds,
            'completed_payments'=>$regular->formatNumbers($escrowPayments),
            'completed_payments_usd'=>$regular->formatNumbers($escrowPaymentsUSD),
            'pending_payments'=> $regular->formatNumbers($escrowPaymentsPending),
            'pending_payments_usd'=> $regular->formatNumbers($escrowPaymentsPendingUSD)
        ];
        return view('dashboard.admin.business_details',$dataView);
    }
    public function doRemove(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['store_ref' => ['bail','required','string'], 'pin' => ['bail','required','digits:6','integer'],],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Account Pin',]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $input = $request->input();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$input['store_ref'])->first();
        if (empty($businessExists)){
            return $this->sendError('Deletion Error',['error'=>'Store does not belong to you.'],
                '422','Deletion Failed');
        }
        //check if business has escrow
        $hasEscrow = Escrows::where('business',$businessExists->id)->first();
        if (!empty($hasEscrow)){
            return $this->sendError('Deletion Error',['error'=>'A transaction has been carried out by this store.'],
                '422','Deletion Failed');
        }
        $deleted = Businesses::where('id',$businessExists->id)->delete();
        if (!$deleted){
            return $this->sendError('Deletion Error',['error'=>'An error occurred while deleting your store'],
                '422','Deletion Failed');
        }
        $success['removed']=true;
        return $this->sendResponse($success, 'Store removed');
    }
    public function verify($ref){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $documentsNeeded = BusinessDocumentTypes::where('country',$user->countryCode)->orWhere('country','all')->get();
        $businessExists = Businesses::where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store not found');
        }
        $documents = BusinessDocuments::where('business',$businessExists->id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Business Verification', 'slogan' => '- Making safer transactions',
            'user' => $user,'documents'=>$documentsNeeded,'business'=>$businessExists,'document'=>$documents];
        return view('dashboard.admin.business_verification', $dataView);
    }
    public function updateVerificationStatus($ref,$status){
        $user = Auth::user();
        $businessExists = Businesses::where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store not found');
        }
        $merchant = User::where('id',$businessExists->merchant)->first();
        $status = $status;
        $dataUpdate=[
            'isVerified'=>$status
        ];
        $update = Businesses::where('id',$businessExists->id)->update($dataUpdate);
        if ($update){
            //Send Notification to Merchant
            $message = 'There is an update on the verification status of your business <b>'.$businessExists->name.'</b>.
            Login to your account to view this update.' ;
            event(new EscrowNotification($merchant, $message, 'Business Verification Update'));
            return back()->with('success','Verification status updated');
        }
        return back()->with('error','Something went wrong');
    }
    public function updateStatus($ref,$status){
        $user = Auth::user();
        $businessExists = Businesses::where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store not found');
        }
        $merchant = User::where('id',$businessExists->merchant)->first();
        $status = $status;
        $dataUpdate=[
            'status'=>$status
        ];
        $update = Businesses::where('id',$businessExists->id)->update($dataUpdate);
        if ($update){
            //Send Notification to Merchant
            $message = 'There is an update on the status of your business <b>'.$businessExists->name.'</b>.
            Login to your account to view this update.' ;
            event(new EscrowNotification($merchant, $message, 'Business Status Update'));
            return back()->with('success','Status updated');
        }
        return back()->with('error','Something went wrong');
    }
}
