<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\MerchantActivities;
use App\Models\MerchantLogins;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Activities extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $activities = MerchantActivities::where('merchant',$user->id)->orderBy('created_at','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Activities','slogan'=>'- Making safer transactions','user'=>$user,
            'activities'=>$activities];
        return view('dashboard.merchant.activities',$dataView);
    }
    public function logins(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $logins = MerchantLogins::where('user',$user->id)->orderBy('id','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Login Activities','slogan'=>'- Making safer transactions','user'=>$user,
            'logins'=>$logins];
        return view('dashboard.merchant.activities',$dataView);
    }
}
