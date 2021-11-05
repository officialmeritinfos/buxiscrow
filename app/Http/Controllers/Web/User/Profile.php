<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\Airtimes;
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
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Account','slogan'=>'- Making safer transactions','user'=>$user,
            'balances'=>$userBalances,'ip'=>$request->ip()
        ];
        return view('dashboard.user.profile',$dataView);
    }
}
