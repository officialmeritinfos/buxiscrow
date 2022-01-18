<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\BusinessSubcategory;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessSubCategories extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $subcategories = BusinessSubcategory::get();
         $categories = BusinessCategory::get();
         $dataView = ['web' => $generalSettings, 'pageName' => 'Business Subcategory', 'slogan' => '- Making safer transactions',
             'user' => $user,'subcategories'=>$subcategories,'categories'=>$categories];
         return view('dashboard.admin.business_subcategory', $dataView);
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
                'category'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'subcategory_name'=>$input['name'],
            'category_id'=>$input['category'],
            'status'=>$input['status'],
        ];

        $created = BusinessSubcategory::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/business_subcategory')->with('success','Business Subcategory added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function edit($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $category = BusinessSubcategory::where('id',$id)->first();
        $categories = BusinessCategory::get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Business Subcategory', 'slogan' => '- Making safer transactions',
            'user' => $user,'category'=>$category,'categories'=>$categories];
        return view('dashboard.admin.edit_business_subcategory', $dataView);
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
                'category'=>['required','numeric',],
                'id'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'subcategory_name'=>$input['name'],
            'category_id'=>$input['category'],
            'status'=>$input['status'],
        ];

        $created = BusinessSubcategory::where('id',$input['id'])->update($dataUpdate);
        if (!empty($created)){
            return redirect('admin/business_subcategory')->with('success','Business Category updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDelete($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = BusinessSubcategory::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/business_subcategory')->with('success','Business Category deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
