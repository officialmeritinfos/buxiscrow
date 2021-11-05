<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserBalances;
use App\Models\UserBeneficiary;
use App\Models\UserReferrals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Referrals extends BaseController
{
   public function index(){
       $generalSettings = GeneralSettings::where('id',1)->first();
       $user=Auth::user();
       $referrals = User::where('refBy',$user->username)->get();
       $balance = UserBalances::where('user',$user->id)->get();
       $dataView=['web'=>$generalSettings,'pageName'=>'Referrals','slogan'=>'- Making safer transactions','user'=>$user,
           'referrals'=>$referrals,'balances'=>$balance];
       return view('dashboard.user.referrals',$dataView);
   }
    public function earnings(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $ref_earning = UserReferrals::where('referredBy',$user->id)->join('users','users.id','=','user_referrals.user')->get();
        $balance = UserBalances::where('user',$user->id)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Referral Earnings','slogan'=>'- Making safer transactions','user'=>$user,
            'ref_trans'=>$ref_earning,'balances'=>$balance];
        return view('dashboard.user.referrals',$dataView);
    }
}
