<?php

namespace App\Http\Controllers\Web\User;

use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Country;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\States;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Settings extends BaseController
{
    public function index()
    {
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $countries = Country::where('region','Africa')->get();
        $state = States::where('iso2',$user->state)->where('country_code',$user->countryCode) ->first();
        $country = Country::where('iso2',$user->countryCode)->first();
        $currency = CurrencyAccepted::where('status',1)->get();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Account Settings', 'slogan' => '- Making safer transactions',
            'user' => $user,'countries'=>$countries,'country'=>$country,'state'=>$state,'currencies'=>$currency];
        return view('dashboard.user.settings', $dataView);
    }

    public function updateProfilePic(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            ['profile_pic' => ['bail', 'required', 'mimes:jpg,bmp,png,jpeg', 'max:3000']],
            ['required' => ':attribute is required'],
            ['profile_pic' => 'Profile Image']
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $fileName = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
        $move = $request->file('profile_pic')->move(public_path('user/photos/'), $fileName);
        if ($move) {
            $dataUser = ['isUploaded' => 1, 'photo' => $fileName];
            $updated = User::where('id', $user->id)->update($dataUser);
            if (!empty($updated)) {
                $details = 'Your ' . config('app.name') . ' account image was successfully set.';
                $dataActivity = ['user' => $user->id, 'activity' => 'Photo update', 'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                $success['uploaded'] = true;
                return $this->sendResponse($success, 'Account Image successfully updated');
            } else {
                return $this->sendError('File Error ', ['error' => 'An error occurred. Please try again or contact support'], '422', 'File Upload Fail');
            }
        } else {
            return $this->sendError('File Error ', ['error' => $move], '422', 'File Upload Fail');
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            ['pin' => ['bail', 'required', 'digits:6'], 'old_password' => ['bail', 'required'], 'new_password' => [Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'required'], 'confirm_password' => 'required|same:new_password'],
            ['required' => ':attribute is required'],
            ['old_password' => 'Current Password', 'new_password' => 'New Password', 'confirm_password' => 'Confirm password']
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $hashed = Hash::check($request->input('old_password'), $user->password);
        $hashed_pin = Hash::check($request->input('pin'), $user->transPin);
        if ($hashed_pin && $hashed) {
            $dataUser = ['password' => bcrypt($request->input('new_password'))];
            $updated = User::where('id', $user->id)->update($dataUser);
            if (!empty($updated)) {
                $details = 'Your ' . config('app.name') . ' account password was reset.';
                $dataActivity = ['user' => $user->id, 'activity' => 'Password reset', 'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                $success['reset'] = true;
                return $this->sendResponse($success, 'Account Password successfully updated');
            }
            return $this->sendError('Authentication Error ', ['error' => 'Unknown error occurred. Please contact support'], '422', 'password change Fail');
        }
        return $this->sendError('Password Error ', ['error' => 'Wrong Credentials. Crosscheck both your old password and transaction pin'], '422', 'password change Fail');
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'name' => ['nullable','string'], 'phone' => ['numeric','required'], 'address' => ['required','string'],
                'country' => ['required','alpha_num',], 'state' => ['required','alpha_num'], 'city' => ['required','string'],
                'zip_code' => ['required','numeric'],'dob' => ['required','date'], 'occupation' => ['nullable','string'],
                'currency' => ['required','alpha','exists:currency_accepted,code'], 'about' => ['nullable','string'],
            ],
            ['required' => ':attribute is required'], ['dob' => 'Date of Birth', 'zip_code' => 'Zip Code',]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $countryExists=Country::where('iso2',$request->input('country'))->first();
        //check if selected state is in the right place
        $stateExistsInCountry = States::where('id',$request->input('state'))->where('country_code',$request->input('country')) ->first();
        if (!empty($stateExistsInCountry)){
            //run same check for city
            $cityExistsInCountry = Cities::where('name',$request->input('city'))->where('state_id',$request->input('state')) ->first();
            if (!empty($cityExistsInCountry)){
                $dataUser=[
                    'phone'=>ltrim($request->input('phone'),'0'),
                    'phoneCode'=>$countryExists->phonecode,
                    'address'=>$request->input('address'),
                    'country'=>$countryExists->name,
                    'countryCode'=>$countryExists->iso2,
                    'countryCodeIso'=>$countryExists->iso3,
                    'state'=>$stateExistsInCountry->iso2,
                    'city'=>$request->input('city'),
                    'zipCode'=>$request->input('zip_code'),
                    'DOB'=>$request->input('dob'),
                    'occupation'=>$request->input('occupation'),
                    'about'=>htmlentities($request->input('about')),
                    'majorCurrency'=>$request->input('currency'),
                    'hasDob'=>1
                ];
                $update = User::where('id',$user->id)->update($dataUser);
                if (!empty($update)){
                    $details = 'Your ' . config('app.name') . ' profile has been updated';
                    $dataActivity = ['user' => $user->id, 'activity' => 'Profile Update', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                    $success['reset'] = true;
                    return $this->sendResponse($success, 'Profile successfully updated. If you are yet to submit required documents please do so.');
                }
                return $this->sendError('Invalid Request', ['error' => 'An error occurred. Please try again'],
                    '422', 'Update Failed');
            }
            return $this->sendError('Invalid City', ['error' => 'Selected city is not supported or not supposed to be in the state selected'],
                '422', 'Validation Failed');
        }
        return $this->sendError('Invalid State', ['error' => 'Selected state is not supported or not supposed to be in the country selected'],
            '422', 'Validation Failed');
    }
    public function switchAccount(){
        $user = Auth::user();
        //switch to merchant
        $dataUser = ['accountType'=>1];
        $update = User::where('id',$user->id)->update($dataUser);
        if (!empty($update)){
            $success['switch'] = true;
            return $this->sendResponse($success, 'Account switch successful. Redirecting soon');
        }
        return $this->sendError('Invalid Account', ['error' => 'Unable to switch account'],
            '422', 'Validation Failed');
    }
}
