<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\UserBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Beneficiary extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $beneficiaries = UserBeneficiary::get();
        $banks = AcceptedBanks::where('status',1)->orderBy('name','asc')->get();
        $currency = CurrencyAccepted::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Recipients','slogan'=>'- Making safer transactions','user'=>$user,
            'beneficiaries'=>$beneficiaries,'banks'=>$banks,'currencies'=>$currency];
        return view('dashboard.admin.beneficiaries',$dataView);
    }
}
