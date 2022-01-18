<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Dashboard extends Controller
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $activeUsers = User::where('status',1)->get();
        $inactiveUsers = User::where('status','!=', 1)->get();
        $users = User::where('status',1)->get();
        $escrows = Escrows::where('status',1)->get();
        $activeEscrows = Escrows::where('status','!=',1)->where('status','!=',3)->get();
        $cancelledEscrows = Escrows::where('status',3)->get();
        $totalEscrow = Escrows::get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Admin Dashboard','slogan'=>'- Making safer transactions','user'=>$user,
            'active_users'=>$activeUsers->count(),'inactive_users'=>$inactiveUsers->count(),'completed_escrows'=>$escrows->count(),
            'active_escrows'=>$activeEscrows->count(),'cancelled_escrows'=>$cancelledEscrows->count(),'escrows'=>$totalEscrow,
            'total_users'=>$users->count()];
        return view('dashboard.admin.dashboard',$dataView);
    }
    public function setPin(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['pin' => ['bail','required','numeric','digits:6'],'confirm_pin' => ['bail','required','numeric','digits:6'],'password' => ['bail','required']],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Transaction Pin','confirm_pin'=>'Confirm Transaction Pin']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors()->all());
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

                return back()->with('success','Account Pin successfully set');
            }else{
                return back()->with('error','Unknown error encountered');
            }
        }
        return back()->with('error','Invalid account password');
    }
}
