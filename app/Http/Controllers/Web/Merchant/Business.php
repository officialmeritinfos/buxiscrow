<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Businesses;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Business extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $businesses = Businesses::where('merchant',$user->id)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Stores','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses
        ];
        return view('dashboard.merchant.businesses',$dataView);
    }
}
