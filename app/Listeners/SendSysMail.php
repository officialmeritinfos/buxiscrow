<?php

namespace App\Listeners;

use App\Events\SendGeneralMail;
use App\Models\UserNotificationSettings;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendSysMail
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
     * @param  SendGeneralMail  $event
     * @return void
     */
    public function handle(SendGeneralMail $event)
    {
        $user = $event->user;
        $message =$event->message;
        $subject = $event->subject;
        $dataMail = [
                'subject'=>$subject,
                'name'=>$user->name,
                'line1'=>' ',
                'line2'=>$message,
                'last_line'=>''
        ];
        Notification::send($user, new SendAuthenticationMail($dataMail,3));
    }
}
