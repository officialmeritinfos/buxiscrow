<?php

namespace App\Http\Controllers\Web;

use App\Events\LoginMail;
use App\Events\TwoFactor;
use App\Events\UserCreated;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\TwoWay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
                    event(new LoginMail($authUser));
                    $token = $authUser->createToken('MyAuthApp')->plainTextToken;
                    $dataUser = ['twoWayPassed' =>1,'loggedIn'=>1];
                    User::where('id',$authUser->id)->update($dataUser);
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
        $dataUser = ['twoWayPassed' =>1,'loggedIn'=>1];
        $user = User::where('id',$authUser->id)->first();
        auth()->user()->tokens()->delete();
        $updated = User::where('id',$user->id)->update($dataUser);
        if (empty($updated)){
            return $this->sendError('Verification Error',['error'=>'unable to update data'],'422','Verification Failed');
        }
        $delete=TwoWay::where('user',$user->id)->delete();
        event(new LoginMail($user));
        $token = $user->createToken('BuxiscrowApp')->plainTextToken;
        $success['loggedIn'] = true;
        $success['token'] = $token;
        $success['account_type']=$user->accountType;
        session('token',$token);
        return $this->sendResponse($success, 'User Logged in');
    }
    public function Logout(Request $request){
        $user=Auth::user();
        $dataUpdate = ['twowayPassed'=>2,'loggedIn'=>2];
        User::where('id',$user->id)->update($dataUpdate);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('info','Successfully logged out');
    }
}
