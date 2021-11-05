<?php

namespace App\Listeners;

use App\Custom\RandomString;
use App\Events\UserCreated;
use App\Models\GeneralSettings;
use App\Models\User;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;


class EmailVerification
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $ranCode = new RandomString(6);
        $code = $ranCode->randomNum();
        $generalSettings = GeneralSettings::find(1);
        $user = $event->user;
        if ($user->emailVerified !=1 && $generalSettings->emailVerification!=1){
            $dataMail = [
                'subject'=>'Email Verification',
                'name'=>$user->name,
                'line1'=>'Thanks for creating your account on <b>'.$generalSettings->siteName.'!</b> To start making secured
                         payments online as well as received bonuses, please activate your account using the code below:',
                'line2'=>'<b style="text-align:center;">'.$code.'</b>',
                'last_line'=>''
            ];
            $dataUser=[
                'emailCode' => $code,
                'codeExpires'=>strtotime($generalSettings->codeExpires,time())
            ];
            User::where('id',$user->id)->update($dataUser);
            Notification::send($user, new SendAuthenticationMail($dataMail,2));
        }
    }
}
