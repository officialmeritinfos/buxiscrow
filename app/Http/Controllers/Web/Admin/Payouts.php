<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\MerchantPayouts;
use App\Models\Payouts as ModelsPayouts;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Payouts extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $merchant_transfers = MerchantPayouts::paginate(10);
        $currencies = CurrencyAccepted::where('status',1)->get();
        $banks = AcceptedBanks::where('status',1)->get();
        $user_transfers = ModelsPayouts::where('user',$user->id)->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Transfers', 'slogan' => '- Making safer transactions',
            'user' => $user,'merchant_transfers'=>$merchant_transfers,'currencies'=>$currencies,'banks'=>$banks,
            'user_transfers'=>$user_transfers];
        return view('dashboard.admin.payouts', $dataView);
    }
    public function userPayoutDetails($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transfer = ModelsPayouts::where('reference',$ref)->first();
        $transactions = Transactions::where('transactionRef',$ref)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Details','slogan'=>'- Making safer transactions','user'=>$user,
            'transaction'=>$transactions,'transfer'=>$transfer];
        return view('dashboard.admin.user_payouts',$dataView);
    }
    public function merchantPayoutDetails($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transfer = MerchantPayouts::where('reference',$ref)->first();
        $transactions = Transactions::where('transactionRef',$ref)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Details','slogan'=>'- Making safer transactions','user'=>$user,
            'transaction'=>$transactions,'transfer'=>$transfer];
        return view('dashboard.admin.merchant_payouts',$dataView);
    }
}
