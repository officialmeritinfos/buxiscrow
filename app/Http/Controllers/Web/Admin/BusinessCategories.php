<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessCategories extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $categories = BusinessCategory::get();
         $dataView = ['web' => $generalSettings, 'pageName' => 'Business Category', 'slogan' => '- Making safer transactions',
             'user' => $user,'categories'=>$categories];
         return view('dashboard.admin.business_category', $dataView);
    }
    public function doAdd(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'name'=>['required','string',],
                'status'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'category_name'=>$input['name'],
            'status'=>$input['status'],
        ];

        $created = BusinessCategory::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/business_category')->with('success','Business Category added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function edit($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $category = BusinessCategory::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Business Category', 'slogan' => '- Making safer transactions',
            'user' => $user,'category'=>$category,];
        return view('dashboard.admin.edit_business_category', $dataView);
    }
    public function doEdit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'name'=>['required','string',],
                'status'=>['required','numeric',],
                'id'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'category_name'=>$input['name'],
            'status'=>$input['status'],
        ];

        $created = BusinessCategory::where('id',$input['id'])->update($dataUpdate);
        if (!empty($created)){
            return redirect('admin/business_category')->with('success','Business Category updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDelete($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = BusinessCategory::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/business_category')->with('success','Business Category deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
