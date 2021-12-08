<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Events\AccountActivity;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\MerchantDocument;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\UserDocumentTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Documents extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $documentsNeeded = UserDocumentTypes::where('country',$user->countryCode)->orWhere('country','all')->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Account Verification', 'slogan' => '- Making safer transactions',
            'user' => $user,'documents'=>$documentsNeeded];
        return view('dashboard.merchant.verify_account', $dataView);
    }
    public function verifyAccount(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'document_type' => ['bail', 'required', 'numeric', 'integer'],
                'front_image' => ['bail', 'required', 'mimes:jpg,bmp,png,jpeg', 'max:5000'],
                'back_image' => ['bail', 'nullable', 'mimes:jpg,bmp,png,jpeg', 'max:5000'],
                'date_issued' => ['bail', 'nullable', 'date'],
                'date_expire' => ['bail', 'nullable', 'date','after:date_issued'],
                'bvn' => ['bail', 'nullable','required_without:ssn'],
                'ssn' => ['bail', 'nullable','required_without:bvn']
            ],
            ['required' => ':attribute is required'],
            ['front_image' => 'Front Image','back_image' => 'Back Image','date_issued' => 'Date Issued',
                'date_expire' => 'Date of Expiration','ssn' => 'Social Security Number','bvn' => 'Bank Verification Number']
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        if ($user->isVerified ==4){
            return $this->sendError('Error validation', ['error' => 'Your account is currently being verified.
            Contact support if you have any questions'], '422', 'Validation Failed');
        }
        if (empty($request->input('bvn'))){
            $secret_id = Crypt::encryptString($request->input('ssn'));
            $hasBvn = 2;
        }else{
            $secret_id = Crypt::encryptString($request->input('bvn'));
            $hasBvn = 1;
        }
        //let's check the document type sent
        $docType = UserDocumentTypes::where('id',$request->input('document_type'))->first();
        if ($docType->hasBack ==1){
            if (empty($request->file('back_image'))){
                return $this->sendError('Error validation', ['error' => 'Back photo of document is required'], '422', 'Validation Failed');
            }
        }
        //move the images
        $fileName1 = $request->file('front_image')->hashName();
        $move1 = $request->file('front_image')->move(public_path('merchant/photos/'), $fileName1);
        //move the second image
        if($docType->hasBack ==1){
            $fileName2 = $request->file('back_image')->hashName();
            $move2 = $request->file('back_image')->move(public_path('merchant/photos/'), $fileName2);
        }else{
            $fileName2='';
            $move2='';
        }
        if ($move1){
            $dataUserDocument = ['merchant'=>$user->id,'documentType'=>$docType->name,'document'=>$fileName1,'back'=>$fileName2,
                'docType'=>$docType->id];
            $dataUser = ['hasBvn' => $hasBvn, 'secret_id' => $secret_id,'isVerified'=>4];
            $addDocument = MerchantDocument::create($dataUserDocument);
            if (!empty($addDocument)){
                $updated = User::where('id', $user->id)->update($dataUser);
                $details = 'Your ' . config('app.name') . ' verification documents has been submitted';
                $dataActivity = ['merchant' => $user->id, 'activity' => 'Verification submission',
                    'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                $success['submitted'] = true;
                return $this->sendResponse($success, 'Verification document successfully submitted.
                You will be contacted if there is ever any need.');
            }else {
                return $this->sendError('File Error ', ['error' => 'An error occurred.
                Please try again or contact support'], '422', 'File Upload Fail');
            }
        } else {
            return $this->sendError('File Error ', ['error' => $move1], '422', 'File Upload Fail');
        }
    }
    public function getDocumentTypeId($id){
        //get the document Type
        $docuType = UserDocumentTypes::where('id',$id)->where('type',2)->where('status',1)->first();
        if (!empty($docuType)){
            $success['back']=$docuType->hasBack;
            $success['r']=$docuType->hasDateIssued;
            $success['expires']=$docuType->hasDateExpire;
            return $this->sendResponse($success, 'Verified.');
        }
        return $this->sendError('Invalid Document', ['error' => 'Selected document is not supported'],
            '422', 'Validation Failed');
    }
}
