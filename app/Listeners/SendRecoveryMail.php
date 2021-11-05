<?php

namespace App\Listeners;

use App\Custom\RandomString;
use App\Events\AccountRecovery;
use App\Models\GeneralSettings;
use App\Models\PasswordResets;
use App\Models\User;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendRecoveryMail
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
     * @param  AccountRecovery  $event
     * @return void
     */
    public function handle(AccountRecovery $event)
    {
        $ranCode = new RandomString(6);
        $code = $ranCode->randomNum();
        $generalSettings = GeneralSettings::find(1);
        $user = $event->user;
        if ($user->status ==1){
            $dataMail = [
                'subject'=>'Account Recovery',
                'name'=>$user->name,
                'line1'=>'There is a password reset request on your  <b>'.config('app.name').'</b> account. To
                          complete this request please verify that you requested for this by using the code below:',
                'line2'=>'<b style="text-align:center;">'.$code.'</b>',
                'last_line'=>''
            ];
            $dataReset=[
                'email' => $user->email,
                'token' => $code,
                'codeExpires'=>strtotime($generalSettings->codeExpires,time())
            ];
            PasswordResets::create($dataReset);
            Notification::send($user, new SendAuthenticationMail($dataMail,2));
        }
    }
}
