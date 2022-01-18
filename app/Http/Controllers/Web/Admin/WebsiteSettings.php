<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WebsiteSettings extends Controller
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
         $user=Auth::user();

         $dataView = ['web' => $generalSettings, 'pageName' => 'Website Settings', 'slogan' => '- Making safer transactions',
             'user' => $user,];
         return view('dashboard.admin.general_settings', $dataView);
    }
    public function doEdit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'name'=>['required','string',],
                'email'=>['required','email',],
                'support'=>['required','email',],
                'dev'=>['required','email',],
                'career'=>['required','email',],
                'legal'=>['required','email',],
                'tag'=>['required','string',],
                'description'=>['required','string',],
                'address'=>['required','string',],
                'user_code'=>['required','string',],
                'site_abbr'=>['required','string',],
                'ref_bonus'=>['required','numeric',],
                'url_link'=>['required','url',],
                'code_expires'=>['required','string',],
                'blog'=>['required','url',],
                'phone'=>['required','string',],
                'celebrate_ref'=>['required','numeric',],
                'celebrate_trans'=>['required','numeric',],
                'android_link'=>['required','url',],
                'ios_link'=>['nullable','url',],
                'merchant_code'=>['required','string',],
                'twoway'=>['required','numeric',],
                'emailverification'=>['required','numeric',],
                'notification'=>['required','numeric',],
                'site_reg'=>['required','numeric',],
            ]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $dataUpdate=[
            'siteName'=>$input['name'],
            'siteEmail'=>$input['email'],
            'siteSupportMail'=>$input['support'],
            'siteDevMail'=>$input['dev'],
            'siteCareerMail'=>$input['career'],
            'legalMail'=>$input['legal'],
            'siteTag'=>$input['tag'],
            'siteDescription'=>$input['description'],
            'siteAbbr'=>$input['site_abbr'],
            'siteAddress'=>$input['address'],
            'merchantCode'=>$input['merchant_code'],
            'userCode'=>$input['user_code'],
            'referralBonus'=>$input['ref_bonus'],
            'emailVerification'=>$input['emailverification'],
            'twoWay'=>$input['twoway'],
            'codeExpires'=>$input['code_expires'],
            'url'=>$input['url_link'],
            'blogLink'=>$input['blog'],
            'phone'=>$input['phone'],
            'referral_celebrate'=>$input['celebrate_ref'],
            'trans_celebrate'=>$input['celebrate_trans'],
            'notification'=>$input['notification'],
            'androidLink'=>$input['android_link'],
            'iphoneLink'=>$input['ios_link'],
            'siteRegistration'=>$input['site_reg'],
        ];

        $updated = GeneralSettings::where('id',1)->update($dataUpdate);
        if ($updated){
            return redirect('admin/general_settings')->with('success','Website Settings updated Successfully');
        }
        return back()->with('error','An error occurred');
    }
}
