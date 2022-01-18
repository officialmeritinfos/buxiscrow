<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\Airtimes;
use App\Models\BankBanks;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\Invoices;
use App\Models\User;
use App\Models\UserBalances;
use App\Models\UserBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{
    public function index(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $userBalances = UserBalances::join('currency_accepted','currency_accepted.code','user_balances.currency')->where('user',$user->id)->get();
        $userAccount = BankBanks::where('user',$user->id)->where('status',1)->where('isApi','!=',1)->first();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Account','slogan'=>'- Making safer transactions','user'=>$user,
            'balances'=>$userBalances,'ip'=>$request->ip(),'user_bank'=>$userAccount
        ];
        return view('dashboard.user.profile',$dataView);
    }
}
