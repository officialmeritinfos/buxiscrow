<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Models\BusinessCustomers;
use App\Models\Businesses;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customers extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $customers = BusinessCustomers::where('merchant',$user->id)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Customers','slogan'=>'- Making safer transactions','user'=>$user,
            'customers'=>$customers
        ];
        return view('dashboard.merchant.customers',$dataView);
    }
    public function details($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $customers = BusinessCustomers::where('merchant',$user->id)->where('id',$id)->first();
        if ($customers->count()<1){
            return back()->with('error','Customer not found');
        }
        $cust = User::where('email',$customers->email)->first();
        $business = Businesses::where('id',$customers->business)->first();
        $escrows = Escrows::where('user',$cust->id)->where('business',$customers->business)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Customers','slogan'=>'- Making safer transactions','user'=>$user,
            'customer'=>$customers,'business'=>$business,'escrows'=>$escrows
        ];
        return view('dashboard.merchant.customer_details',$dataView);
    }
}
