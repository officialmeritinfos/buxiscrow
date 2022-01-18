<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class More extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $currency = CurrencyAccepted::get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'System Settings', 'slogan' => '- Making safer transactions',
            'user' => $user,'currencies'=>$currency];
        return view('dashboard.admin.more', $dataView);
    }
}
