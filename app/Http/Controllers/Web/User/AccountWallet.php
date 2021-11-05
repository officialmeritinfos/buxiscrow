<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\AccountFunding;
use App\Models\GeneralSettings;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountWallet extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $userBalances = UserBalances::where('user',$user->id)->get();
        $accountFunding = AccountFunding::where('user',$user->id)->orderBy('id','desc')->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Account Wallets', 'slogan' => '- Making safer transactions',
            'user' => $user,'balances'=>$userBalances,'fundings'=>$accountFunding];
        return view('dashboard.user.account_wallet', $dataView);
    }
}
