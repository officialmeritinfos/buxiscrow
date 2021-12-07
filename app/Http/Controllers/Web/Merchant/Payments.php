<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\PayBusinessTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Payments extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $payments = PayBusinessTransactions::where('merchant',$user->id)->orderBy('id','desc')->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Payments','slogan'=>'- Making safer transactions','user'=>$user,
            'payments'=>$payments
        ];
        return view('dashboard.merchant.payments',$dataView);
    }
}
