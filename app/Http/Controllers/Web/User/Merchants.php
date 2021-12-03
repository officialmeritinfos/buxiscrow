<?php

namespace App\Http\Controllers\Web\User;

use App\Custom\CustomChecks;
use App\Custom\Regular;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\BusinessCustomers;
use App\Models\Businesses;
use App\Models\BusinessSubcategory;
use App\Models\BusinessType;
use App\Models\EscrowPayments;
use App\Models\EscrowReports;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\Refunds;
use App\Models\UserActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Merchants extends BaseController
{
    public function index(Request $request){
        $business = $request->get('business');
        $businesses = (!isset($business)) ? Businesses::where('status',1)->orderBy('isVerified','asc')->paginate(15)
            :
            Businesses::where('name','LIKE','%'.$business.'%')->orWhere('businessEmail','LIKE','%'.$business.'%')->orWhere('businessPhone','LIKE','%'.$business.'%')
                ->orWhere('businessCountry','LIKE','%'.$business.'%')->orWhere('businessState','LIKE','%'.$business.'%')->orWhere('businessCity','LIKE','%'.$business.'%')
                ->orWhere('businessAddress','LIKE','%'.$business.'%')->orWhere('Zip','LIKE','%'.$business.'%')->orWhere('businessTag','LIKE','%'.$business.'%')
                ->orderBy('isVerified','asc')->paginate(15);
        $businesses->appends(['business'=>$business]);
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $dataView=['web'=>$generalSettings,'pageName'=>'Merchants','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses,'search'=>$business];
        return view('dashboard.user.merchant_list',$dataView);
    }
    public function details($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $regular = new Regular();
        $checks = new CustomChecks();
        $businessExists = Businesses::where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store or Merchant not found');
        }
        $category = $checks::categoryVar($businessExists->category);
        $subcategory = $checks::subcategoryVar($businessExists->subcategory);
        $businessType = BusinessType::where('id',$businessExists->businessType)->first();
        $escrows = Escrows::where('business',$businessExists->id)->get();

        $completedTransaction = Escrows::where('business',$businessExists->id)
            ->where('status',1)->count();
        $cancelledTransaction = Escrows::where('business',$businessExists->id)
            ->where('status',3)->count();
        $pendingTransactions = Escrows::where('business',$businessExists->id)
            ->where('status',2)->count();
        $reportedTransactions = EscrowReports::where('business',$businessExists->id)
            ->where('merchantLost',1)->count();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Store Information','slogan'=>'- Making safer transactions','user'=>$user,
            'business'=>$businessExists,'type'=>$businessType,'category'=>$category,'subcategory'=>$subcategory,
            'escrows'=>$escrows,
            'completed_transactions'=>$regular->formatNumbers($completedTransaction),
            'pending_transactions'=>$regular->formatNumbers($pendingTransactions),
            'cancelled_transactions'=> $regular->formatNumbers($cancelledTransaction),
            'credit_score'=> (100 -($reportedTransactions/$escrows->count())*100).'%'
        ];
        return view('dashboard.user.merchant_details',$dataView);
    }
}
