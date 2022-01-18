<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountFunding;
use App\Models\GeneralSettings;
use App\Models\SendMoney;
use App\Models\Transactions as ModelsTransactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transactions extends Controller
{
    public function index(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = ($request->has('sort'))? ModelsTransactions::where('user',$request->sort)->get():ModelsTransactions::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions];
        return view('dashboard.admin.transactions',$dataView);
    }
    public function details($reference){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = ModelsTransactions::where('transactionRef',$reference)->first();
        $users = User::where('id',$transactions->user)->first();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transaction Details','slogan'=>'- Making safer transactions','user'=>$user,
            'transaction'=>$transactions,'users'=>$users];
        return view('dashboard.admin.transaction_details',$dataView);
    }
    public function accountFundings(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = ($request->has('sort'))? AccountFunding::where('user',$request->sort)->get():AccountFunding::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Account Fundings','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions];
        return view('dashboard.admin.account_funding',$dataView);
    }
    public function sendMoney(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = ($request->has('sort'))? SendMoney::where('user',$request->sort)->get():SendMoney::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Send Money Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions];
        return view('dashboard.admin.send_money_transactions',$dataView);
    }
}
