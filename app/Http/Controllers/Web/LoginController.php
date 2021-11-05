<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //view login page
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $currency =CurrencyAccepted::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Login Page','slogan'=>'- Making safer transactions','currencies'=>$currency];
        return view('dashboard.login',$dataView);
    }
    //2FA view page
    public function twoFactor(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $currency =CurrencyAccepted::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'2FA','slogan'=>'- Making safer transactions','currencies'=>$currency];
        return view('dashboard.twoway',$dataView);
    }
}
