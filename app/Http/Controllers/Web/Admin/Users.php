<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\EscrowNotification;
use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use App\Models\Logins;
use App\Models\MerchantBalances;
use App\Models\MerchantLogins;
use App\Models\User;
use App\Models\UserBalances;
use App\Models\UserDocument;
use App\Models\UserNotificationSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Users extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::orderBy('id','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Users','slogan'=>'- Making safer transactions','user'=>$user,
            'users'=>$users];
        return view('dashboard.admin.users',$dataView);
    }
    public function details($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $notificationSetting = UserNotificationSettings::where('user',$users->id)->first();
        $userBalances = UserBalances::join('currency_accepted','currency_accepted.code','user_balances.currency')
            ->where('user',$users->id)->get();
        $merchantBalances = MerchantBalances::join('currency_accepted','currency_accepted.code','merchant_balances.currency')
                ->where('merchant',$users->id)->get();
        $userLogins = Logins::where('user',$users->id)->get();
        $merchantLogins = MerchantLogins::where('user',$users->id)->paginate(
            $perPage = 10, $columns = ['*'], $pageName = 'logins'
        );
        $dataView=['web'=>$generalSettings,'pageName'=>'Users','slogan'=>'- Making safer transactions','user'=>$user,
            'users'=>$users,'balances'=>$userBalances,'merchantBalances'=>$merchantBalances,'notification'=>$notificationSetting,
            'userLogins'=>$userLogins,'merchantLogins'=>$merchantLogins];
        return view('dashboard.admin.user_details',$dataView);
    }
    public function updateLevel($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $currentLevel = $users->userLevel;
        $newLevel = $currentLevel+1;
        $dataUser = [
            'userLevel'=>$newLevel
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to Merchant
            $message = 'Your account on '.config('app.name').' has been upgraded to Level '.$newLevel.'. This means
            that your account limit has been consequently increased.<br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, 'Account Upgrade'));
            return back()->with('success','Account successfully Upgraded');
        }
        return back()->with('error','An error occurred');
    }
    public function downgradeLevel($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $currentLevel = $users->userLevel;
        $newLevel = $currentLevel-1;
        if ($newLevel < 1){
            return back()->with('error','User account level cannot be zero.');
        }
        $dataUser = [
            'userLevel'=>$newLevel
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to Merchant
            $message = 'Your account on '.config('app.name').' has been downgraded to Level '.$newLevel.'. This means
            that your account limit has been consequently increased.<br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, 'Account Upgrade'));
            return back()->with('success','Account successfully Upgraded');
        }
        return back()->with('error','An error occurred');
    }
    public function activateTwo($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'twoWay'=>1
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to User
            $message = '2FA has been activated for your account on '.config('app.name').' This is our little way
            of ensuring that your account is not compromised.
            <br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, '2FA Activation on '.config('app.name')));
            return back()->with('success','2FA successfully activated');
        }
        return back()->with('error','An error occurred');
    }
    public function deactivateTwo($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'twoWay'=>2
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to User
            $message = '2FA has been deactivated for your account on '.config('app.name').' If this was an error
            please contact our support center immediately for help.
            <br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, '2FA Deactivation on '.config('app.name')));
            return back()->with('success','2FA successfully deactivated');
        }
        return back()->with('error','An error occurred');
    }
    public function activateSend($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'canSend'=>1
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to User
            $message = 'Transfer has been activated for your account on '.config('app.name').'
            <br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, 'Transfer Activation on '.config('app.name')));
            return back()->with('success','Transfer successfully activated');
        }
        return back()->with('error','An error occurred');
    }
    public function deactivateSend($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'canSend'=>2
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to User
            $message = 'Transfer has been deactivated for your account on '.config('app.name').'
            If you have any question concerning this action, please contact our support center for more
            information, and how to undo this action.
            <br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, 'Transfer Deactivation on '.config('app.name')));
            return back()->with('success','Transfer successfully deactivated');
        }
        return back()->with('error','An error occurred');
    }
    public function activateUser($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'status'=>1
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to User
            $message = 'Your account on '.config('app.name').' has been activated. You can now continue
            your use of our platform for the uttermost secured transaction,
            <br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, 'Account Activation on '.config('app.name')));
            return back()->with('success','Account successfully activated');
        }
        return back()->with('error','An error occurred');
    }
    public function deactivateUser($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'status'=>2
        ];
        $update = User::where('id',$users->id)->update($dataUser);
        if ($update){
            //Send Notification to User
            $message = 'Your account on '.config('app.name').' has been deactivated.
            If you have any question concerning this action, please contact our support center for more
            information, and how to undo this action.
            <br> Thanks for using '.config('app.name') ;
            event(new EscrowNotification($users, $message, 'Account Deactivation on '.config('app.name')));
            return back()->with('success','Account successfully deactivated');
        }
        return back()->with('error','An error occurred');
    }
    public function activateNotification($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'login_notification'=>1,
            'news_letters'=>1,
            'account_activity'=>1
        ];
        $update = UserNotificationSettings::where('user',$users->id)->update($dataUser);
        if ($update){
            return back()->with('success','Account notification successfully activated');
        }
        return back()->with('error','An error occurred');
    }
    public function deactivateNotification($id){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $dataUser = [
            'login_notification'=>2,
            'news_letters'=>2,
            'account_activity'=>2
        ];
        $update = UserNotificationSettings::where('user',$users->id)->update($dataUser);
        if ($update){
            return back()->with('success','Account notification successfully deactivated');
        }
        return back()->with('error','An error occurred');
    }
    public function increaseIndividualTransactionLimit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $dataNewLimit = [
            'TransactionLimit'=>$input['amount']
        ];
        //update record
        $update = UserBalances::where('currency',$input['balance'])->where('user',$users->id)->update($dataNewLimit);
        if ($update) {
            return back()->with('success','User Individual Transaction Limit successfully updated');
        }
    }
    public function increaseIndividualAccountLimit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $dataNewLimit = [
            'AccountLimit'=>$input['amount']
        ];
        //update record
        $update = UserBalances::where('currency',$input['balance'])->where('user',$users->id)->update($dataNewLimit);
        if ($update) {
            return back()->with('success','User Individual Account Limit successfully updated');
        }
    }
    public function increaseBusinessTransactionLimit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $dataNewLimit = [
            'TransactionLimit'=>$input['amount']
        ];
        //update record
        $update = MerchantBalances::where('currency',$input['balance'])->where('merchant',$users->id)->update($dataNewLimit);
        if ($update) {
            return back()->with('success','User Business Transaction Limit successfully updated');
        }
    }
    public function increaseBusinessAccountLimit(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $dataNewLimit = [
            'AccountLimit'=>$input['amount']
        ];
        //update record
        $update = MerchantBalances::where('currency',$input['balance'])->where('merchant',$users->id)->update($dataNewLimit);
        if ($update) {
            return back()->with('success','User Business Account Limit successfully updated');
        }
    }
    public function viewDocuments($id)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $users = User::where('id',$id)->first();
        if (empty($users)){
            return back()->with('error','User account not found');
        }
        $documents = UserDocument::where('user',$users->id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'User Verification', 'slogan' => '- Making safer transactions',
            'user' => $user,'document'=>$documents,'users'=>$users];
        return view('dashboard.admin.user_verification', $dataView);
    }
    public function updateVerificationStatus($ref,$status){
        $user = Auth::user();
        $userExists = User::where('id',$ref)->first();
        if (empty($userExists)){
            return back()->with('error','User not found');
        }
        $status = $status;
        $dataUpdate=[
            'isVerified'=>$status
        ];
        $update = User::where('id',$userExists->id)->update($dataUpdate);
        if ($update){
            //Send Notification to User
            $message = 'There is an update on the verification status of your account.
            Login to your account to view this update.' ;
            event(new EscrowNotification($userExists, $message, 'Account Verification Update'));
            return back()->with('success','Verification status updated');
        }
        return back()->with('error','Something went wrong');
    }
    public function fundIRefBal(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $balance = UserBalances::where('currency',$input['balance'])->where('user',$users->id)->first();
        $newBalance = $balance->referralBalance+$input['amount'];
        $dataBalance = [
            'referralBalance'=>$newBalance
        ];
        //update record
        $update = UserBalances::where('currency',$input['balance'])->where('user',$users->id)->update($dataBalance);
        if ($update) {
            return back()->with('success','Individual Referral Balance Topped Up successfully');
        }
    }
    public function fundIAvaBal(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $balance = UserBalances::where('currency',$input['balance'])->where('user',$users->id)->first();
        $newBalance = $balance->availableBalance+$input['amount'];
        $dataBalance = [
            'availableBalance'=>$newBalance
        ];
        //update record
        $update = UserBalances::where('currency',$input['balance'])->where('user',$users->id)->update($dataBalance);
        if ($update) {
            return back()->with('success','Individual Available Balance Topped Up successfully');
        }
    }
    public function fundBRefBal(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $balance = MerchantBalances::where('currency',$input['balance'])->where('merchant',$users->id)->first();
        $newBalance = $balance->referralBalance+$input['amount'];
        $dataBalance = [
            'referralBalance'=>$newBalance
        ];
        //update record
        $update = MerchantBalances::where('currency',$input['balance'])->where('merchant',$users->id)->update($dataBalance);
        if ($update) {
            return back()->with('success','Business Referral Balance Topped Up successfully');
        }
    }
    public function fundBAvaBal(Request $request)
    {
        $generalSettings = GeneralSettings::where('id',1)->first();
        //let's check the where the account will be credited
        $validator = Validator::make($request->all(),
            [
                'amount'=>['required','numeric',],
                'id'=>['required'],
                'balance'=>['required','alpha']
            ],
            ['required'  =>':attribute is required'],
            ['id'   =>'User','balance'=>'Balance']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $id= $input['id'];
        $users = User::where('id',$id)->first();
        $balance = MerchantBalances::where('currency',$input['balance'])->where('merchant',$users->id)->first();
        $newBalance = $balance->availableBalance+$input['amount'];
        $dataBalance = [
            'availableBalance'=>$newBalance
        ];
        //update record
        $update = MerchantBalances::where('currency',$input['balance'])->where('merchant',$users->id)->update($dataBalance);
        if ($update) {
            return back()->with('success','Business Available Balance Topped Up successfully');
        }
    }
    public function userId($id)
    {
        $user = User::where('id',$id)->first();
        return $user;
    }
}
