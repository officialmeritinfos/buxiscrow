<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCustomers;
use App\Models\Businesses;
use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customers extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $customers = BusinessCustomers::get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Customers','slogan'=>'- Making safer transactions','user'=>$user,
            'customers'=>$customers
        ];
        return view('dashboard.admin.customers',$dataView);
    }
    public function details($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user = Auth::user();
        $customers = BusinessCustomers::where('id',$id)->first();
        if ($customers->count()<1){
            return back()->with('error','Customer not found');
        }
        $cust = User::where('email',$customers->email)->first();
        $business = Businesses::where('id',$customers->business)->first();
        $escrows = Escrows::where('user',$cust->id)->where('business',$customers->business)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Customers Details','slogan'=>'- Making safer transactions','user'=>$user,
            'customer'=>$customers,'business'=>$business,'escrows'=>$escrows
        ];
        return view('dashboard.admin.customer_details',$dataView);
    }
}
