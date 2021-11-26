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
    public function convertReferral(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric']],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Withdrawal Amount']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $refBalance = MerchantBalances::where('merchant',$user->id)->where('currency',$user->majorCurrency)->first();
        return $this->checkReferralBalanceForConversion($request, $refBalance, $user);
    }
    public function convertSpecificReferral(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric'],'currency' => ['bail','required','alpha']],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Withdrawal Amount']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $refBalance = MerchantBalances::where('merchant',$user->id)->where('currency',$request->input('currency'))->first();
        return $this->checkReferralBalanceForConversion($request, $refBalance, $user);
    }

    /**
     * @param Request $request
     * @param $refBalance
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkReferralBalanceForConversion(Request $request, $refBalance, ?\Illuminate\Contracts\Auth\Authenticatable $user): \Illuminate\Http\JsonResponse
    {
        if ($request->amount > $refBalance->referralBalance) {
            return $this->sendError('Insufficient Fund', ['error' => 'Insufficient Fund in ' . $refBalance->currency . ' Referral Account'], '422', 'Validation Failed');
        }
        $refBal = $refBalance->referralBalance - $request->amount;
        $newBal = $refBalance->availableBalance + $request->amount;
        $balData = [
            'availableBalance' => $newBal,
            'referralbalance' => $refBal
        ];
        $updateBalance = MerchantBalances::where('id', $refBalance->id)->update($balData);
        if (!empty($updateBalance)) {
            $details = 'Your ' . $refBalance->currency . ' Referral Balance was debited of ' . $refBalance->currency . '
                        ' . $request->amount . ' at ' . date('d-m-Y h:i:s a') . ' and converted to corresponding available
                        balance';
            $dataActivity = ['merchant' => $user->id, 'activity' => 'Referral Balance Debit', 'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            $success['convert'] = true;
            return $this->sendResponse($success, 'conversion successful');
        }
        return $this->sendError('Error Converting', ['error' => 'There was an Error converting'], '4011', 'Conversion Failed');
    }
    public function convertToNGN(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['amount' => ['bail','required','numeric'],'currency' => ['bail','required','alpha']],
            ['required'  =>':attribute is required'],
            ['amount'   =>'Withdrawal Amount']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $userBalance = MerchantBalances::where('merchant',$user->id)->where('currency',$request->input('currency'))->first();
        $acceptedCurrency = CurrencyAccepted::where('code',strtoupper($request->input('currency')))->where('status',1)->first();
        $userNgnBalance = MerchantBalances::where('merchant',$user->id)->where('currency','NGN')->first();
        if ($request->input('amount') > $userBalance->availableBalance) {
            return $this->sendError('Insufficient Fund', ['error' => 'Insufficient Fund in ' . $userBalance->currency . ' Available Account'],
                '422', 'Validation Failed');
        }
        $rateNGN = $acceptedCurrency->rateNGN;
        $newAmount = $rateNGN*$request->input('amount');
        $newBal = $userNgnBalance->availableBalance + $newAmount;
        $newCurrBalance = $userBalance->availableBalance - $request->input('amount');
        if ($userNgnBalance->AccountLimit > $newBal){
            return $this->sendError('Error converting',['error'=>'Conversion failed. Amount above account Limit'],
                '422','Conversion Failed');
        }
        $balData = [
            'availableBalance' => $newBal,
        ];
        $convertedBalanceData = [
            'availableBalance' => $newCurrBalance,
        ];
        $updateBalance = MerchantBalances::where('id', $userNgnBalance->id)->update($balData);
        if (!empty($updateBalance)){
            $updateConvertedBalance = MerchantBalances::where('id', $userBalance->id)->update($convertedBalanceData);
            $details = 'Your ' . $userBalance->currency . ' Available Balance was debited of ' . $userBalance->currency . '
                        ' . number_format($request->amount,2) . ' at ' . date('d-m-Y h:i:s a') . ' and
                        converted to NGN available balance';
            $dataActivity = ['merchant' => $user->id, 'activity' => 'Balance Conversion', 'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            $success['convert'] = true;
            return $this->sendResponse($success, 'conversion successful');
        }
        return $this->sendError('Error Converting', ['error' => 'There was an Error converting your '.$userBalance->currency.' balance to NGN'],
            '4011', 'Conversion Failed');
    }
    public function getSpecificCurrencyData($currency){
        $currencyData = CurrencyAccepted::where('code',$currency)->first();
        if (!empty($currencyData)){
            $success['currency']=$currencyData->code;
            $success['name']=$currencyData->currency;
            $success['rateUsd']=$currencyData->rateUsd;
            $success['rateNGN']=$currencyData->rateNGN;
            return $this->sendResponse($success, 'fetched');
        }
        return $this->sendError('Error', ['error' => 'Unsupported currency queried'],
            '4011', 'Fetch Failed');
    }
}
