<?php

namespace App\Http\Controllers\Api;

use App\Custom\RandomString;
use App\Custom\Regular;
use App\Events\AccountRecovery;
use App\Events\AccountRecoveryMail;
use App\Events\LoginMail;
use App\Events\SendWelcomeMail;
use App\Events\TwoFactor;
use App\Events\UserCreated;
use App\Http\Controllers\Api\BaseController;
use App\Models\GeneralSettings;
use App\Models\PasswordResets;
use App\Models\TwoWay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['bail','required','email','exists:users,email'],
            'password' => ['bail','required',Password::min(8),],
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $authUser = Auth::user();
            if ($authUser->emailVerified !=1){
                event(new UserCreated($authUser));
                $token = $authUser->createToken('BuxiscrowApp')->plainTextToken;
                $success['name']=$authUser->name;
                $success['needVerification'] = true;
                $success['token']=$token;
                $message='Please activate account to proceed';
                return $this->sendResponse($success, $message);
            }
            switch ($authUser->twoWay){
                case 1:
                    event(new TwoFactor($authUser));
                    $token = $authUser->createToken('MyAuthApp')->plainTextToken;
                    $success['token'] =  $token;
                    $success['name'] =  $authUser->name;
                    $success['needAuth'] = true;
                    return $this->sendResponse($success, 'Authentication needed');
                    break;
                case 2:
                    event(new LoginMail($authUser,$request->ip()));
                    $token = $authUser->createToken('MyAuthApp')->plainTextToken;
                    $success['token'] =  $token;
                    $success['name'] =  $authUser->name;
                    $success['needAuth'] = false;
                    $success['loggedIn'] = true;
                    $success['account_type']=$authUser->accountType;
                    return $this->sendResponse($success, 'User signed in');
                    break;
            }
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Either password or email is wrong'],'403','Access Denied');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|string|max:50',
            'username' => 'bail|required|alpha_num|unique:users,username|max:20' ,
            'email' => ['bail','required','email','unique:users,email'],
            'phone' => ['bail','required','numeric'],
            'referral'=>['bail','nullable','alpha_num','exists:users,username'],
            'account_type'=>['bail','nullable','integer'],
            'password' => ['bail','required',Password::min(8)->letters()->mixedCase()->numbers()->symbols(),],
            'currency' =>['bail','required',Rule::exists('currency_accepted','code')->where(function ($query){return $query->where('status',1);}),],
            'confirm_password' => 'bail|required|same:password',
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $phone = Str::of($request->phone)->ltrim('0');
        if (!empty($request->referral)){
            $referral = User::where('username',$request->referral)->first();
            $ref = $referral->username;
        }else{
            $ref = '';
        }
        $type = (empty($request->account_type)) ? 2 : $request->account_type;

        $ipAddress = $request->ip();
        //get the user's country
        $ipDetector = new Regular();
        $location = $ipDetector->getUserCountry($ipAddress);
        if ($location->ok()){
            $location = $location->json();
            $country = $location['country_name'];
            $country_code = $location['country_code2'];
            $country_code3 = $location['country_code3'];
            $userIp = $ipAddress;
            $phoneCode = $location['calling_code'];
        }
        $randomString = new RandomString(8);
        $generalSettings = GeneralSettings::find(1);
        if ($generalSettings->siteRegistration != 1){
            return $this->sendError('Error Creating account', ['error'=>'New Registration is currently disabled.
            Please contact support for more information.'],'401','account error');
        }
        $userRef = $generalSettings->userCode.'_'.$randomString->randomNum();
        $validated = $validator->validated();
        $userData = ['name'=>$validated['name'],'username'=>$validated['username'],'email'=>$validated['email'],'phone'=>$phone,'emailVerified'=>$generalSettings->emailVerification,
            'twoWay'=>$generalSettings->twoWay,'password'=>bcrypt($validated['password']),'creation_ip'=>$userIp,'userRef'=>$userRef,'accountType'=>$type,
            'country'=>$country,'countryCode'=>$country_code,'countryCodeIso'=>$country_code3,'phoneCode'=>$phoneCode,'refBy'=>$ref,'majorCurrency'=>$validated['currency']
        ];
        $user = User::create($userData);
        if(!empty($user)) {
            switch ($generalSettings->emailVerification){
                case 1:
                    event(new SendWelcomeMail($user));
                    event(new UserCreated($user));
                    $success['name']=$user->name;
                    $success['ip'] = $userIp;
                    $success['needVerification'] = false;
                    $message='Account successfully created, proceed to login';
                    break;
                case 2:
                    event(new UserCreated($user));
                    $token = $user->createToken('BuxiscrowApp')->plainTextToken;
                    $success['name']=$user->name;
                    $success['needVerification'] = true;
                    $success['token']=$token;
                    $success['ip'] = $userIp;
                    $message='Account successfully created. Use the code sent to your mail to verify your account';
                    session('token',$token);
                    break;
            }
            return $this->sendResponse($success, $message);
        }else{
            return $this->sendError('Error Creating account', ['error'=>'An error has occurred while creating your
            account.'],'401','account error');
        }
    }
    public function emailVerification(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        $validator = Validator::make($request->all(),
            ['code' => ['bail','required','numeric','digits:6',Rule::exists('users','emailCode')->where(function ($query){return $query->where('codeExpires','>=',time());})]],
            ['required'  =>':attribute is required'],
            ['code'   =>'Verification Code']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $dataUser = [
            'emailVerified' =>1,
            'emailCode'     =>'',
            'codeExpires'   =>''
        ];
        $update = User::where('id',$authUser->id)->update($dataUser);
        if (!$update){
            return $this->sendError('Verification Error',['error'=>'Unable to update data'],'422','Verification Failed');
        }
        $user = User::where('id',$authUser->id)->first();
        event(new SendWelcomeMail($user));
        auth()->user()->tokens()->delete();
        $success['verified'] = true;
        return $this->sendResponse($success, 'Email successfully verified.');
    }
    public function resendEmail(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        event(new UserCreated($authUser));
        $success['resent'] = true;
        return $this->sendResponse($success, 'Mail Resent');
    }
    public function resendTwoway(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        event(new TwoFactor($authUser));
        $success['resent'] = true;
        return $this->sendResponse($success, 'Mail Resent');
    }
    public function resendPasswordReset(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        event(new AccountRecovery($authUser));
        $success['resent'] = true;
        return $this->sendResponse($success, 'Mail Resent');
    }
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(),
            ['bail','email' => ['required','email','exists:users,email',]],
            ['required'  =>':attribute is required'],
            ['email'   =>'Account Email']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        //set the reset password mechanism
        //get the user that has the email
        $user = User::where('email',$request->email)->where('status',1)->first();
        if (empty($user)){
            return $this->sendError('Inactive account',['error'=>'Account is deactivated. Contact support'],'422','Inactive account');
        }
        event(new AccountRecovery($user));
        $token = $user->createToken('BuxiscrowApp')->plainTextToken;
        $success['token'] = $token;
        $success['name']  = $user->name;
        $success['sent']  = true;
        session('token',$token);
        return $this->sendResponse($success, 'Recovery Mail sent');
    }
    public function authenticateResetRequest(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        $validator = Validator::make($request->all(),
            ['code' => ['bail','required','numeric','digits:6',Rule::exists('password_resets','token')->where(function ($query){return $query->where('codeExpires','>=',time());})]],
            ['required'  =>':attribute is required'],
            ['code'   =>'Verification Code']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $delete = PasswordResets::where('email',$authUser->email)->delete();
        if (!$delete){
            return $this->sendError('Verification Error',['error'=>'Unable to update data'],'422','Verification Failed');
        }

        $user = User::where('id',$authUser->id)->first();
        auth()->user()->tokens()->delete();

        $token = $user->createToken('BuxiscrowApp')->plainTextToken;
        $success['verified'] = true;
        $success['token'] = $token;

        session('token',$token);
        return $this->sendResponse($success, 'Request successfully confirmed.');
    }
    public function changePassword(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        $validator = Validator::make($request->all(), [
            'password' => ['bail','required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),],
            'confirm_password' => 'bail|required|same:password',
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $dataUser = ['password'=>bcrypt($request->password)];
        $user = User::where('id',$authUser->id)->update($dataUser);
        if (empty($user)){
            return $this->sendError('Verification Error',['error'=>'Unable to update data'],'422','Verification Failed');
        }
        $users = User::where('id',$authUser->id)->first();
        event(new AccountRecoveryMail($users));
        auth()->user()->tokens()->delete();

        $success['reset'] = true;
        return $this->sendResponse($success, 'Password has been reset');
    }
    public function twoWay(Request $request){
        //lets verify the user
        $authUser = Auth::user();
        $validator = Validator::make($request->all(),
            ['code' => ['bail','required','numeric','digits:6']],
            ['required'  =>':attribute is required'],
            ['code'   =>'2FA Code']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $twoWay = TwoWay::where('user',$authUser->id)->where('codeExpires','>=',time())->orderBy('id','desc')->first();
        if (empty($twoWay)){
            return $this->sendError('Verification Error',['error'=>'Invalid Token sent'],'422','Verification Failed');
        }
        $hashed = Hash::check($request->code,$twoWay->code);
        if (!$hashed){
            return $this->sendError('Verification Error',['error'=>'Invalid Token sent'],'422','Verification Failed');
        }
        $dataUser = ['twoWayPassed' =>1];
        $user = User::where('id',$authUser->id)->first();
        auth()->user()->tokens()->delete();
        $updated = User::where('id',$user->id)->update($dataUser);
        if (empty($updated)){
            return $this->sendError('Verification Error',['error'=>'unable to update data'],'422','Verification Failed');
        }
        $delete=TwoWay::where('user',$user->id)->delete();
        event(new LoginMail($user,$request->ip()));
        $token = $user->createToken('BuxiscrowApp')->plainTextToken;
        $success['loggedIn'] = true;
        $success['token'] = $token;
        $success['account_type']=$user->accountType;
        session('token',$token);
        return $this->sendResponse($success, 'User Logged in');
    }
    public function logout(Request $request){
        $authUser = Auth::user();
        $dataUser = ['twoWayPassed' =>2];
        $updated = User::where('id',$authUser->id)->update($dataUser);
        if (empty($updated)){
            return $this->sendError('Verification Error',['error'=>'unable to update data'],'422','Verification Failed');
        }
        auth()->user()->tokens()->delete();
        $success['loggedIn'] = false;
        $success['loggedOut'] = true;
        $request->session()->forget('token');
        return $this->sendResponse($success, 'User successfully logged out');
    }
}
