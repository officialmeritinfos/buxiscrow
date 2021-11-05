<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\AccountFunding;
use App\Models\Escrows as escrowsTransactions;
use App\Models\GeneralSettings;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Escrows extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $escrows = escrowsTransactions::where('user',$user->id)->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Escrow Transactions', 'slogan' => '- Making safer transactions',
            'user' => $user,'escrows'=>$escrows,];
        return view('dashboard.user.escrows', $dataView);
    }
}
