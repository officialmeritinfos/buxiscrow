<?php

namespace App\Listeners;

use App\Events\AccountRecoveryMail;
use App\Models\GeneralSettings;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendAccountRecoveryMail
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
     * @param  AccountRecoveryMail  $event
     * @return void
     */
    public function handle(AccountRecoveryMail $event)
    {
        $generalSettings = GeneralSettings::find(1);
        $user = $event->user;
        if ($user ->emailVerified ==1){
            $dataMail = [
                'subject'=>'Account Access Change',
                'name'=>$user->name,
                'line1'=>'Your '.config('app.name').' account login has been changed.',
                'line2'=>'If this was not initiated by you, then your account has been compromised, and your funds could
                          be stolen. Contact our technical support right away to prevent any further damage to your account.',
                'last_line'=>''
            ];
            Notification::send($user, new SendAuthenticationMail($dataMail,3));
        }
    }
}
