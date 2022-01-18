<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Businesses;
use App\Models\DeliveryLocations;
use App\Models\EscrowApprovals;
use App\Models\EscrowDeliveries;
use App\Models\EscrowPayments;
use App\Models\EscrowReports;
use App\Models\Escrows as ModelsEscrows;
use App\Models\GeneralSettings;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Escrows extends Controller
{
    public function index(Request $request)
    {

        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $escrows = ($request->has('sort'))? ModelsEscrows::where('user',$request->sort)->orWhere('merchant',$request->sort)->get():ModelsEscrows::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Escrows','slogan'=>'- Making safer transactions','user'=>$user,
            'escrows'=>$escrows];
        return view('dashboard.admin.escrows',$dataView);
    }
    public function details($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $escrow = ModelsEscrows::where('reference',$ref)->first();
        if (empty($escrow)){
            return back()->with('error','Escrow not found ');
        }
        $payer = User::where('id',$escrow->user)->first();
        $merchant = User::where('id',$escrow->merchant)->first();
        $business = Businesses::where('id',$escrow->business)->where('merchant',$escrow->merchant)->first();
        $payment = EscrowPayments::where('escrowId',$escrow->id)->where('user',$escrow->user)->first();
        $reports = EscrowReports::where('escrow_id',$escrow->id)->where('user',$escrow->user)->first();
        $payer = User::where('id',$escrow->user)->first();
        $escrow_delivery = EscrowDeliveries::where('escrowId',$escrow->id)->first();
        $logisticsLocation = DeliveryLocations::where('id',$escrow->logistics)->first();
        if (!empty($logisticsLocation)){
            $logisticCompany = DeliveryLocations::where('id',$logisticsLocation->logisticsId)->first();
        }else{
            $logisticCompany = '';
        }
        $escrow_approvals = EscrowApprovals::where('escrowId',$escrow->id)->where('escrowRef',$escrow->reference)->first();
        $report_types = ReportType::where('status',1)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Escrow Details','slogan'=>'- Making safer transactions','user'=>$user,
            'escrow'=>$escrow,'business'=>$business,'payment'=>$payment,'report'=>$reports,'payer'=>$payer,'escrow_delivery'=>$escrow_delivery,
            'logisticsLocation'=>$logisticsLocation,'logistics'=>$logisticCompany,'approval'=>$escrow_approvals,
            'report_types'=>$report_types,'merchant'=>$merchant
        ];
        return view('dashboard.admin.escrow_details',$dataView);
    }
}
