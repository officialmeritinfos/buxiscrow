<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Revenues extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $currency = CurrencyAccepted::get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'System Revenues', 'slogan' => '- Making safer transactions',
            'user' => $user,'currencies'=>$currency];
        return view('dashboard.admin.revenues', $dataView);
    }
    public function details($code)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $currency = CurrencyAccepted::where('code',$code)->first();

        $dataView = ['web' => $generalSettings, 'pageName' => 'System Revenues in '.$code, 'slogan' => '- Making safer transactions',
            'user' => $user,'currency'=>$currency->code];
        return view('dashboard.admin.revenue_details', $dataView);
    }
}
