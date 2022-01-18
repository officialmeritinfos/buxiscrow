<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\MerchantBalances;
use App\Models\User;
use App\Models\UserReferrals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Referrals extends Controller
{
    public function index(){
        $user = Auth::user();
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $referrals = User::where('refBy',$user->username)->get();
        $balance = MerchantBalances::where('merchant',$user->id)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Referrals','slogan'=>'- Making safer transactions','user'=>$user,
            'referrals'=>$referrals,'balances'=>$balance];
        return view('dashboard.admin.referrals',$dataView);
    }

    public function earnings(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $ref_earning = UserReferrals::where('referredBy',$user->id)->join('users','users.id','=','user_referrals.user')->get();
        $balance = MerchantBalances::where('merchant',$user->id)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Referral Earnings','slogan'=>'- Making safer transactions','user'=>$user,
            'ref_trans'=>$ref_earning,'balances'=>$balance];
        return view('dashboard.admin.referrals',$dataView);
    }
}
