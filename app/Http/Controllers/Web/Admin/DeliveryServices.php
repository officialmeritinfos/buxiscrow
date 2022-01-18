<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\DeliveryLocations;
use App\Models\DeliveryService;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeliveryServices extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $deliveryServices = DeliveryService::get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Delivery Services', 'slogan' => '- Making safer transactions',
            'user' => $user,'delivery_services'=>$deliveryServices];
        return view('dashboard.admin.delivery_services', $dataView);
    }
    public function doDelete($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = DeliveryService::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/delivery_services')->with('success','Delivery Service deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function edit($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delivery = DeliveryService::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Delivery Services', 'slogan' => '- Making safer transactions',
            'user' => $user,'delivery'=>$delivery,];
        return view('dashboard.admin.edit_delivery_services', $dataView);
    }
    public function doEdit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'name'=>['required','string',],
                'phone'=>['required','string',],
                'status'=>['required','numeric',],
                'id'=>['required','numeric',],
                'logo' => ['bail','nullable', 'mimes:jpg,bmp,png,jpeg', 'max:6000'],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        //get delivery service
        $delivery = DeliveryService::where('id',$input['id'])->first();

        if (empty($request->file('logo'))){
            $logo =$delivery->logo;
            if (!empty($logo)) {
                $uploaded =1;
            }else{
                $uploaded=2;
            }
        }else{
            $logo = $request->file('logo')->hashName();
            $move2 = $request->file('logo')->move(public_path('merchant/photos/'), $logo);
            $uploaded = 1;
        }
        $dataUpdate=[
            'name'=>$input['name'],
            'phone'=>$input['phone'],
            'status'=>$input['status'],
            'logo'=>$logo,
            'logoUploaded'=>$uploaded
        ];

        $created = DeliveryService::where('id',$input['id'])->update($dataUpdate);
        if (!empty($created)){
            return redirect('admin/delivery_services')->with('success','Delivery Service updated Successfully');
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
                'name'=>['required','string',],
                'phone'=>['required','string',],
                'status'=>['required','numeric',],
                'logo' => ['nullable', 'mimes:jpg,bmp,png,jpeg', 'max:6000'],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        //get delivery service
        $delivery = DeliveryService::where('name',$input['name'])->first();
        if (!empty($delivery)) {
            return back()->with('error','Delivery Service already added');
        }

        if (empty($request->file('logo'))){
            $logo ='';
            if (!empty($logo)) {
                $uploaded =1;
            }else{
                $uploaded=2;
            }
        }else{
            $logo = $request->file('logo')->hashName();
            $move2 = $request->file('logo')->move(public_path('merchant/photos/'), $logo);
            $uploaded = 1;
        }
        $dataUpdate=[
            'name'=>$input['name'],
            'phone'=>$input['phone'],
            'status'=>$input['status'],
            'logo'=>$logo,
            'logoUploaded'=>$uploaded
        ];

        $created = DeliveryService::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/delivery_services')->with('success','Delivery Service added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function deliveryLocation($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $locations = DeliveryLocations::where('logisticsId',$id)->get();
        $currencies = CurrencyAccepted::where('status',1)->get();
        $deliveryServices = DeliveryService::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Delivery Locations', 'slogan' => '- Making safer transactions',
            'user' => $user,'delivery'=>$deliveryServices,'locations'=>$locations,'currencies'=>$currencies];
        return view('dashboard.admin.delivery_locations', $dataView);
    }
    public function doAddLocation(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'country'=>['required','string',],
                'city'=>['required','string',],
                'state'=>['required','string',],
                'country_code'=>['required','string',],
                'currency'=>['required','alpha',],
                'amount'=>['required','string',],
                'status'=>['required','numeric',],
                'id'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        //check if delivery location already exists
        $delivery = DeliveryLocations::where('logisticsId',$input['id'])->where('State',$input['state'])
            ->where('City',$input['city'])->where('country',$input['country'])
            ->first();
        if (!empty($delivery)) {
            return back()->with('error','Location has already been added');
        }
        $dataUpdate=[
            'country'=>$input['country'],
            'City'=>$input['city'],
            'State'=>$input['state'],
            'countryCode'=>$input['country_code'],
            'Charge'=>$input['amount'],
            'currency'=>$input['currency'],
            'status'=>$input['status'],
            'logisticsId'=>$input['id'],
        ];

        $created = DeliveryLocations::create($dataUpdate);
        if (!empty($created)){
            return back()->with('success','Delivery Location added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDeleteLocation($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = DeliveryLocations::where('id',$id)->delete();
        if ($delete) {
            return back()->with('success','Delivery Location deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
