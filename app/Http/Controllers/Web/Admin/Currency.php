<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Currency extends Controller
{
    public function index()
     {
         $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $currencies = CurrencyAccepted::get();
         $dataView = ['web' => $generalSettings, 'pageName' => 'Accepted Currencies', 'slogan' => '- Making safer transactions',
             'user' => $user,'currencies'=>$currencies];
         return view('dashboard.admin.currency', $dataView);
     }
    public function edit($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $currency = CurrencyAccepted::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Currency', 'slogan' => '- Making safer transactions',
            'user' => $user,'currency'=>$currency,];
        return view('dashboard.admin.edit_currency', $dataView);
    }
    public function doEdit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'currency'=>['required','string',],
                'code'=>['required','alpha',],
                'country'=>['required','alpha',],
                'usd_rate'=>['required','numeric',],
                'ngn_rate'=>['required','numeric',],
                'charge'=>['required','numeric',],
                'base_charge'=>['required','numeric',],
                'min_charge'=>['required','numeric',],
                'max_charge'=>['required','numeric',],
                'internal_charge'=>['required','numeric',],
                'min_send_money_charge'=>['required','numeric',],
                'max_send_money_charge'=>['required','numeric',],
                'nonescrow_charge'=>['required','numeric',],
                'nonEscrowChargeMax'=>['required','numeric',],
                'nonEscrowChargeMin'=>['required','numeric',],
                'verifiedBusinessLimit'=>['required','numeric',],
                'unverifiedBusinessLimit'=>['required','numeric',],
                'unverifiedIndividualLimit'=>['required','numeric',],
                'verifiedBusinessTransactionLimit'=>['required','numeric',],
                'verifiedIndividualLimit'=>['required','numeric',],
                'unverifiedBusinessTransactionLimit'=>['required','numeric',],
                'verifiedIndividualTransactionLimit'=>['required','numeric',],
                'unverifiedIndividualTransactionLimit'=>['required','numeric',],
                'settlementPeriod'=>['required','string',],
                'status'=>['required','numeric',],
                'id'=>['required','integer',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'currency'=>$input['currency'],
            'code'=>$input['code'],
            'country'=>$input['country'],
            'rateUsd'=>$input['usd_rate'],
            'rateNGN'=>$input['ngn_rate'],
            'charge'=>$input['charge'],
            'baseCharge'=>$input['base_charge'],
            'minCharge'=>$input['min_charge'],
            'maxCharge'=>$input['max_charge'],
            'internalCharge'=>$input['internal_charge'],
            'sendMoneyChargeMin'=>$input['min_send_money_charge'],
            'sendMoneyChargeMax'=>$input['max_send_money_charge'],
            'nonEscrowCharge'=>$input['nonescrow_charge'],
            'nonEscrowChargeMax'=>$input['nonEscrowChargeMax'],
            'nonEscrowChargeMin'=>$input['nonEscrowChargeMin'],
            'verifiedBusinessLimit'=>$input['verifiedBusinessLimit'],
            'unverifiedBusinessLimit'=>$input['unverifiedBusinessLimit'],
            'unverifiedIndividualLimit'=>$input['unverifiedIndividualLimit'],
            'verifiedBusinessTransactionLimit'=>$input['verifiedBusinessTransactionLimit'],
            'verifiedIndividualLimit'=>$input['verifiedIndividualLimit'],
            'unverifiedBusinessTransactionLimit'=>$input['unverifiedBusinessTransactionLimit'],
            'verifiedIndividualTransactionLimit'=>$input['verifiedIndividualTransactionLimit'],
            'unverifiedIndividualTransactionLimit'=>$input['unverifiedIndividualTransactionLimit'],
            'settlementPeriod'=>$input['settlementPeriod'],
            'status'=>$input['status'],
        ];

        $updated = CurrencyAccepted::where('id',$input['id'])->update($dataUpdate);
        if ($updated){
            return redirect('admin/currency')->with('success','Currency updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doAdd(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'currency'=>['required','string',],
                'code'=>['required','alpha',],
                'country'=>['required','alpha',],
                'usd_rate'=>['required','numeric',],
                'ngn_rate'=>['required','numeric',],
                'charge'=>['required','numeric',],
                'base_charge'=>['required','numeric',],
                'min_charge'=>['required','numeric',],
                'max_charge'=>['required','numeric',],
                'internal_charge'=>['required','numeric',],
                'min_send_money_charge'=>['required','numeric',],
                'max_send_money_charge'=>['required','numeric',],
                'nonescrow_charge'=>['required','numeric',],
                'nonEscrowChargeMax'=>['required','numeric',],
                'nonEscrowChargeMin'=>['required','numeric',],
                'verifiedBusinessLimit'=>['required','numeric',],
                'unverifiedBusinessLimit'=>['required','numeric',],
                'unverifiedIndividualLimit'=>['required','numeric',],
                'verifiedBusinessTransactionLimit'=>['required','numeric',],
                'verifiedIndividualLimit'=>['required','numeric',],
                'unverifiedBusinessTransactionLimit'=>['required','numeric',],
                'verifiedIndividualTransactionLimit'=>['required','numeric',],
                'unverifiedIndividualTransactionLimit'=>['required','numeric',],
                'settlementPeriod'=>['required','string',],
                'status'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        //check if currency already exists
        $currencyExists = CurrencyAccepted::where('code',$input['code'])->first();
        if (!empty($currencyExists)) {
            return back()->with('error','Currency Already added');
        }
        $dataUpdate=[
            'currency'=>$input['currency'],
            'code'=>$input['code'],
            'country'=>$input['country'],
            'rateUsd'=>$input['usd_rate'],
            'rateNGN'=>$input['ngn_rate'],
            'charge'=>$input['charge'],
            'baseCharge'=>$input['base_charge'],
            'minCharge'=>$input['min_charge'],
            'maxCharge'=>$input['max_charge'],
            'internalCharge'=>$input['internal_charge'],
            'sendMoneyChargeMin'=>$input['min_send_money_charge'],
            'sendMoneyChargeMax'=>$input['max_send_money_charge'],
            'nonEscrowCharge'=>$input['nonescrow_charge'],
            'nonEscrowChargeMax'=>$input['nonEscrowChargeMax'],
            'nonEscrowChargeMin'=>$input['nonEscrowChargeMin'],
            'verifiedBusinessLimit'=>$input['verifiedBusinessLimit'],
            'unverifiedBusinessLimit'=>$input['unverifiedBusinessLimit'],
            'unverifiedIndividualLimit'=>$input['unverifiedIndividualLimit'],
            'verifiedBusinessTransactionLimit'=>$input['verifiedBusinessTransactionLimit'],
            'verifiedIndividualLimit'=>$input['verifiedIndividualLimit'],
            'unverifiedBusinessTransactionLimit'=>$input['unverifiedBusinessTransactionLimit'],
            'verifiedIndividualTransactionLimit'=>$input['verifiedIndividualTransactionLimit'],
            'unverifiedIndividualTransactionLimit'=>$input['unverifiedIndividualTransactionLimit'],
            'settlementPeriod'=>$input['settlementPeriod'],
            'status'=>$input['status'],
        ];

        $created = CurrencyAccepted::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/currency')->with('success','Currency added Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
