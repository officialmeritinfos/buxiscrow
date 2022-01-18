<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessType as ModelsBusinessType;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessType extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $business_types = ModelsBusinessType::get();
         $dataView = ['web' => $generalSettings, 'pageName' => 'Business Types', 'slogan' => '- Making safer transactions',
             'user' => $user,'business_types'=>$business_types];
         return view('dashboard.admin.business_type', $dataView);
    }
    public function doAdd(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'name'=>['required','string',],
                'isCrypto'=>['required','numeric',],
                'status'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        //check if currency already exists
        $currencyExists = ModelsBusinessType::where('name',$input['name'])->first();
        if (!empty($currencyExists)) {
            return back()->with('error','Business Type Already added');
        }
        $dataUpdate=[
            'name'=>$input['name'],
            'isCrypto'=>$input['isCrypto'],
            'status'=>$input['status'],
        ];

        $created = ModelsBusinessType::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/business_type')->with('success','Business Type added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function edit($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $business_types = ModelsBusinessType::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Business Type', 'slogan' => '- Making safer transactions',
            'user' => $user,'business_type'=>$business_types,];
        return view('dashboard.admin.edit_business_type', $dataView);
    }
    public function doEdit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'name'=>['required','string',],
                'isCrypto'=>['required','numeric',],
                'status'=>['required','numeric',],
                'id'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'name'=>$input['name'],
            'isCrypto'=>$input['isCrypto'],
            'status'=>$input['status'],
        ];

        $created = ModelsBusinessType::where('id',$input['id'])->update($dataUpdate);
        if (!empty($created)){
            return redirect('admin/business_type')->with('success','Business Type updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDelete($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = ModelsBusinessType::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/business_type')->with('success','Business Type deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
