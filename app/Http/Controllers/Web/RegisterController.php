<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //view register page
    public function index(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $currency =CurrencyAccepted::where('status',1)->get();
        $ref= $request->input('referrals');
        $dataView=['web'=>$generalSettings,'pageName'=>'Registration Page','slogan'=>'- Making safer transactions',
            'currencies'=>$currency,'ref'=>$ref];
        return view('dashboard.register',$dataView);
    }
    //email verification
    public function emailVerify(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $currency =CurrencyAccepted::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Email Verification','slogan'=>'- Making safer transactions','currencies'=>$currency];
        return view('dashboard.emailverify',$dataView);
    }
}
