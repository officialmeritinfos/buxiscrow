<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReportTypes extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $report_types = ReportType::get();
         $dataView = ['web' => $generalSettings, 'pageName' => 'Report Types', 'slogan' => '- Making safer transactions',
             'user' => $user,'report_types'=>$report_types];
         return view('dashboard.admin.report_type', $dataView);
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
        $code = time().mt_rand();
        $dataUpdate=[
            'report_name'=>$input['name'],
            'report_code'=>$code,
            'status'=>$input['status'],
        ];

        $created = ReportType::create($dataUpdate);
        if (!empty($created)){
            return redirect('admin/report_type')->with('success','Report Type added Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function edit($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $report_type = ReportType::where('id',$id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Edit Report Type', 'slogan' => '- Making safer transactions',
            'user' => $user,'report_type'=>$report_type,];
        return view('dashboard.admin.edit_report_type', $dataView);
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
            'report_name'=>$input['name'],
            'status'=>$input['status'],
        ];

        $created = ReportType::where('id',$input['id'])->update($dataUpdate);
        if (!empty($created)){
            return redirect('admin/report_type')->with('success','Report Type updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
    public function doDelete($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $delete = ReportType::where('id',$id)->delete();
        if ($delete) {
            return redirect('admin/report_type')->with('success','Report Type deleted Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
