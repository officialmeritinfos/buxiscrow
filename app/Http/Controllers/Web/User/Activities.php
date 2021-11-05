<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Logins;
use App\Models\UserActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Activities extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $activities = UserActivities::where('user',$user->id)->orderBy('created_at','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Activities','slogan'=>'- Making safer transactions','user'=>$user,
            'activities'=>$activities];
        return view('dashboard.user.activities',$dataView);
    }
    public function logins(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $logins = Logins::where('user',$user->id)->orderBy('id','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Login Activities','slogan'=>'- Making safer transactions','user'=>$user,
            'logins'=>$logins];
        return view('dashboard.user.activities',$dataView);
    }
}
