<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\AcceptedBanks;
use App\Models\Airtimes;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\Invoices;
use App\Models\Escrows;
use App\Models\MerchantBalances;
use App\Models\User;
use App\Models\UserBalances;
use App\Models\UserBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Dashboard extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $referrals = User::where('refBy',$user->username)->where('status',1)->count();
        $ref_count = $referrals / $generalSettings->referral_celebrate;
        $celebrate_ref = ($ref_count >= 1) ? 1:2;
        $balance = MerchantBalances::where('merchant',$user->id)->get();
        $invoices = Invoices::where('merchant',$user->id)->limit('5')->orderBy('id','desc')->get();
        $escrows = Escrows::where('merchant',$user->id)->limit('5')->orderBy('id','desc')->get();
        $currencies = CurrencyAccepted::where('status',1)->get();
        $banks = AcceptedBanks::where('status',1)->get();
        $beneficiaries = UserBeneficiary::where('user',$user->id)->where('status',1)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Dashboard','slogan'=>'- Making safer transactions','user'=>$user,
            'referrals'=>$referrals,'celebrate_ref'=>$celebrate_ref,'balance'=>$balance,'escrows'=>$escrows,'invoices'=>$invoices,
            'currencies'=>$currencies];
        return view('dashboard.merchant.home',$dataView);
    }
    //set transaction pin
    public function setPin(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['pin' => ['bail','required','numeric','digits:6'],'confirm_pin' => ['bail','required','numeric','digits:6'],'password' => ['bail','required']],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Transaction Pin','confirm_pin'=>'Confirm Transaction Pin']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $hashed = Hash::check($request->input('password'),$user->password);
        if ($hashed){
            $dataUser =['transPin'=>bcrypt($request->input('pin')),'setPin'=>1];
            $update = User::where('id',$user->id)->update($dataUser);
            if (!empty($update)){
                $details = 'Your '.config('app.name').' Transaction pin was successfully set.' ;
                $dataActivity = ['merchant' => $user->id, 'activity' => 'Security update', 'details' => $details,
                    'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                event(new SendNotification($user, $details, '3'));
                $success['completed']=true;
                return $this->sendResponse($success, 'Account Pin successfully updated');
            }else{
                return $this->sendError('Invalid Request',['error'=>'Unknown error encountered'],'422','Security update fail');
            }
        }
        return $this->sendError('Invalid Request',['error'=>'Invalid account password'],'422','Validation Failed');
    }
}
