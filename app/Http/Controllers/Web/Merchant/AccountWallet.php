<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\MerchantFunding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountWallet extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $userBalances = MerchantBalances::where('merchant',$user->id)->get();
        $accountFunding = MerchantFunding::where('merchant',$user->id)->orderBy('id','desc')->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Account Wallets', 'slogan' => '- Making safer transactions',
            'user' => $user,'balances'=>$userBalances,'fundings'=>$accountFunding];
        return view('dashboard.merchant.account_wallet', $dataView);
    }
}
