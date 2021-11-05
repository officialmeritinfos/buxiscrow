<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\UserActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoreActions extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $activities = UserActivities::where('user',$user->id)->orderBy('created_at','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Actions','slogan'=>'- Making safer transactions','user'=>$user,
            'activities'=>$activities];
        return view('dashboard.user.more_actions',$dataView);
    }
}
