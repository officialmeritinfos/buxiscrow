<?php

namespace App\Listeners;

use App\Custom\RandomString;
use App\Events\TwoFactor;
use App\Models\GeneralSettings;
use App\Models\TwoWay;
use App\Models\User;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTwoFactorMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TwoFactor  $event
     * @return void
     */
    public function handle(TwoFactor $event)
    {
        $ranCode = new RandomString(6);
        $code = $ranCode->randomNum();
        $generalSettings = GeneralSettings::find(1);
        $user = $event->user;
        if ($user->twoWay == 1){
            $dataMail = [
                'subject'=>'Two Factor Authentication',
                'name'=>$user->name,
                'line1'=>'There is a login attempt on your  <b>'.config('app.name').'</b> account. To complete this
                          request please authorize this login the code below:',
                'line2'=>'<b style="text-align:center;">'.$code.'</b>',
                'last_line'=>''
            ];
            $dataUser=[
                'code' => bcrypt($code),
                'codeExpires'=>strtotime($generalSettings->codeExpires,time()),
                'email'=>$user->email,
                'user'=>$user->id,
            ];
            TwoWay::create($dataUser);
            Notification::send($user, new SendAuthenticationMail($dataMail,2));
        }
    }
}
