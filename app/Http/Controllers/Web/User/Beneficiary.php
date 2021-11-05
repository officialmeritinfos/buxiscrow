<?php

namespace App\Http\Controllers\Web\User;

use App\Custom\FlutterWave;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Models\UserActivities;
use App\Models\UserBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Beneficiary extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $beneficiaries = UserBeneficiary::where('user',$user->id)->get();
        $banks = AcceptedBanks::where('status',1)->orderBy('name','asc')->get();
        $currency = CurrencyAccepted::where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Transfer Recipients','slogan'=>'- Making safer transactions','user'=>$user,
            'beneficiaries'=>$beneficiaries,'banks'=>$banks,'currencies'=>$currency];
        return view('dashboard.user.beneficiaries',$dataView);
    }
    public function addBeneficiary(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            [
                'banks'=>['required','numeric','exists:accepted_banks,bankCode'],
                'currency'=>['required','alpha','exists:currency_accepted,code'],
                'account_number'=>['required'],
                'account_name'=>['required']
            ],
            ['required'  =>':attribute is required'],
            ['account_name'   =>'Account Name','account_number'=>'Account Number']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        //check if the record already exists
        $beneficiaryExists = UserBeneficiary::where('currency',$request->input('currency'))
                            ->where('accountNumber',$request->input('account_number'))
                            ->where('bankCode',$request->input('banks'))->first();
        if (empty($beneficiaryExists)){
            $dataBeneficiary = [
                'account_number'=>$request->input('account_number'),'account_bank'=>$request->input('banks'),
                'beneficiary_name'=>$request->input('account_name'),'currency'=>$request->input('currency')
            ];
            //send to endpoint for addition
            $gateway = new FlutterWave();
            $createBaneficiary = $gateway->createBeneficiary($dataBeneficiary);
            if ($createBaneficiary->ok()){
                $createBaneficiary = $createBaneficiary->json();
                $beneficiaryData = ['beneficiaryId'=>$createBaneficiary['data']['id'],'user'=>$user->id,
                    'bank'=>$createBaneficiary['data']['bank_name'],'bankCode'=>$request->input('banks'),'accountNumber'=>$request->input('account_number'),
                    'accountName'=>$createBaneficiary['data']['full_name'],'currency'=>$request->input('currency')
                ];
                $addBeneficiary = UserBeneficiary::create($beneficiaryData);
                if (!empty($addBeneficiary)){
                    $details = 'New transfer recipient was added on your '.config('app.name').' account.';
                    $dataActivity = ['user' => $user->id, 'activity' => 'Transfer Receipient', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                    $success['added']=true;
                    return $this->sendResponse($success, 'Beneficiary added');
                }else{
                    return $this->sendError('Invalid Request',['error'=>'Unknown error encountered'],'422','update fail');
                }
            }else{
                $createBaneficiary = $createBaneficiary->json();
                return $this->sendError('Invalid Request',['error'=>$createBaneficiary['message'] ],'422','Validation Failed');
            }
        }else{
            //we will copy the data into his own account if he is not the original owner
            if ($beneficiaryExists->user != $user->id){
                $beneficiaryData = ['beneficiaryId'=>$beneficiaryExists->beneficiaryId ,'user'=>$user->id,
                    'bank'=>$beneficiaryExists->bank,'bankCode'=>$beneficiaryExists->bankCode,'accountNumber'=>$beneficiaryExists->accountNumber,
                    'accountName'=>$beneficiaryExists->accountName,'currency'=>$beneficiaryExists->currency
                ];
                $addBeneficiary = UserBeneficiary::create($beneficiaryData);
                if (!empty($addBeneficiary)){
                    $details = 'New transfer recipient was added on your '.config('app.name').' account.';
                    $dataActivity = ['user' => $user->id,'activity' => 'Transfer Receipient', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                    $success['added']=true;
                    return $this->sendResponse($success, 'Beneficiary added');
                }else{
                    return $this->sendError('Invalid Request',['error'=>'Unknown error encountered'],'422','update fail');
                }
            }
            return $this->sendError('Invalid Request',['error'=>'Account Details already exists'],'422','Validation Failed');
        }
    }
    public function removeBeneficiary(Request $request,$beneficiary_id){
        $user = Auth::user();
        //check if there's a user that has the same person as a beneficiary
        $beneficiaryExistsAnother = UserBeneficiary::where('beneficiaryId',$beneficiary_id)->where('user','!=',$user->id)->first();
        $beneficiaryExists = UserBeneficiary::where('beneficiaryId',$beneficiary_id)->where('user',$user->id)->first();
        if (!empty($beneficiaryExistsAnother)){
            UserBeneficiary::where('user',$user->id)->where('id',$beneficiaryExists->id)->delete();
            $details = 'Transfer recipient was removed from your '.config('app.name').' account list of beneficiary.';
            $dataActivity = ['user' => $user->id,'activity' => 'Transfer Recipient Removal', 'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            $success['removed']=true;
            return $this->sendResponse($success, 'Beneficiary removed');
        }else{
            $gateway = new FlutterWave();
            $removeBeneficiary = $gateway->removeBeneficiary($beneficiary_id);
            if ($removeBeneficiary->ok()){
                UserBeneficiary::where('user',$user->id)->where('id',$beneficiaryExists->id)->delete();
                $details = 'Transfer recipient was removed from your '.config('app.name').' account list of beneficiary.';
                $dataActivity = ['user' => $user->id,'activity' => 'Transfer Recipient Removal', 'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                $success['removed']=true;
                return $this->sendResponse($success, 'Beneficiary removed');
            }else{
                $removeBeneficiary = $removeBeneficiary->json();
                return $this->sendError('Invalid Request',['error'=>$removeBeneficiary['message'].'.
                Please contact support if this is an error'],'422','Validation Failed');
            }
        }
    }
}
