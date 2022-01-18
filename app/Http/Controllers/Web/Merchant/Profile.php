<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\BankBanks;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends BaseController
{
    public function index(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $userBalances = MerchantBalances::join('currency_accepted','currency_accepted.code','merchant_balances.currency')->where('merchant',$user->id)->get();
        $userAccount = BankBanks::where('user',$user->id)->where('status',1)->where('isApi','!=',1)->first();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Account','slogan'=>'- Making safer transactions','user'=>$user,
            'balances'=>$userBalances,'ip'=>$request->ip(),'user_bank'=>$userAccount
        ];
        return view('dashboard.merchant.profile',$dataView);
    }
}
