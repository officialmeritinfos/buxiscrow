<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;

class ResetController extends Controller
{
    //recoverPassword view page
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Recovery Page','slogan'=>'- Making safer transactions',];
        return view('dashboard.recoverpassword',$dataView);
    }
    //confirm password reset view page
    public function confirmReset(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Confirm Login Reset','slogan'=>'- Making safer transactions',];
        return view('dashboard.verifyresetpassword',$dataView);
    }
    //reset password view page
    public function resetPassword(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Change Passwords','slogan'=>'- Making safer transactions',];
        return view('dashboard.resetpassword',$dataView);
    }
}
