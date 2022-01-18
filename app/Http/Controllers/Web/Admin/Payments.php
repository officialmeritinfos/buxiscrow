<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\PayBusinessTransactions;
use App\Models\PaymentLinkPayments;
use App\Models\PaymentLinks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Payments extends Controller
{
    public function index(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $paymentLinks = PaymentLinks::paginate(10);
        $transactions = ($request->has('sort'))? PayBusinessTransactions::where('merchant',$request->sort)->get():PayBusinessTransactions::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Internal Business Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions,'paymentLinks'=>$paymentLinks];
        return view('dashboard.admin.payments',$dataView);
    }
    public function paymentLinksTransactions(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = ($request->has('sort'))? PaymentLinkPayments::where('reference',$request->sort)->get():PayBusinessTransactions::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Payment Link Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions];
        return view('dashboard.admin.payment_link_transactions',$dataView);
    }
    public function paymentLinksTransaction(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $transactions = ($request->has('sort'))? PaymentLinkPayments::where('reference',$request->sort)->get():PayBusinessTransactions::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Payment Link Transactions','slogan'=>'- Making safer transactions','user'=>$user,
            'transactions'=>$transactions];
        return view('dashboard.admin.payment_link_transactions',$dataView);
    }
}
