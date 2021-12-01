<?php

namespace App\Http\Controllers\Web\Merchant;

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
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Actions','slogan'=>'- Making safer transactions','user'=>$user];
        return view('dashboard.merchant.more_actions',$dataView);
    }
}
