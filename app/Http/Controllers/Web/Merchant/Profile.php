<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
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
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Account','slogan'=>'- Making safer transactions','user'=>$user,
            'balances'=>$userBalances,'ip'=>$request->ip()
        ];
        return view('dashboard.merchant.profile',$dataView);
    }
}
