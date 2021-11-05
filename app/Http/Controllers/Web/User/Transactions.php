<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Transactions as transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transactions extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = transaction::where('user',$user->id)->orderBy('id','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions];
        return view('dashboard.user.transactions',$dataView);
    }
    public function details($reference){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = transaction::where('user',$user->id)->where('transactionRef',$reference)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transaction Details','slogan'=>'- Making safer transactions','user'=>$user,
            'transaction'=>$transactions];
        return view('dashboard.user.transaction_details',$dataView);
    }
}
