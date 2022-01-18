<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq as ModelsFaq;
use App\Models\FaqCategory;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Faq extends Controller
{
    /** FAQ CATEGORY */
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $category = FaqCategory::get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Faq Category', 'slogan' => '- Making safer transactions',
            'user' => $user,'categories'=>$category];
        return view('dashboard.admin.faq_category', $dataView);
    }
    public function editCategory($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $category = FaqCategory::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Faq Category', 'slogan' => '- Making safer transactions',
            'user' => $user,'category'=>$category];
        return view('dashboard.admin.edit_faq_category', $dataView);
    }
    public function doEditCategory(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'title'=>['required','string',],
                'id'=>['required','integer'],
                'description'=>['required']
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'category_name'=>$input['title'],
            'description'=>$input['description']
        ];

        $update = FaqCategory::where('id',$input['id'])->update($dataUpdate);
        if ($update){
            return redirect('admin/faq_category')->with('success','Faq Category Updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doAddCategory(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'title'=>['required','string',],
                'description'=>['required']
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'category_name'=>$input['title'],
            'description'=>$input['description']
        ];

        $created = FaqCategory::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/faq_category')->with('success','Faq Category added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDeleteCategory($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = FaqCategory::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/faq_category')->with('success','Faq Category deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
     /** FAQ */
     public function faqs()
     {
         $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $category = FaqCategory::get();
         $faq = ModelsFaq::get();
         $dataView = ['web' => $generalSettings, 'pageName' => 'Faq', 'slogan' => '- Making safer transactions',
             'user' => $user,'categories'=>$category,'faqs'=>$faq];
         return view('dashboard.admin.faq', $dataView);
     }
    public function doAddFaq(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'question'=>['required','string',],
                'answer'=>['required'],
                'category'=>['required'],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'question'=>$input['question'],
            'answer'=>$input['answer'],
            'category_id'=>$input['category']
        ];

        $created = ModelsFaq::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/faqs')->with('success','Faq  added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function editFaq($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $faq = ModelsFaq::where('id',$id)->first();
        $categories = FaqCategory::get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Faq', 'slogan' => '- Making safer transactions',
            'user' => $user,'faq'=>$faq,'categories'=>$categories];
        return view('dashboard.admin.edit_faq', $dataView);
    }
    public function doEditFaq(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'question'=>['required','string',],
                'answer'=>['required'],
                'id'=>['required'],
                'category'=>['required'],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'question'=>$input['question'],
            'answer'=>$input['answer'],
            'category_id'=>$input['category']
        ];

        $updated = ModelsFaq::where('id',$input['id'])->update($dataUpdate);
        if ($updated){
            return redirect('admin/faqs')->with('success','Faq updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDeleteFaq($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = ModelsFaq::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/faqs')->with('success','Faq deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
