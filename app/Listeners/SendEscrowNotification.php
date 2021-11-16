<?php

namespace App\Listeners;

use App\Events\EscrowNotification;
use App\Models\UserNotificationSettings;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendEscrowNotification
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
     * @param  EscrowNotification  $event
     * @return void
     */
    public function handle(EscrowNotification $event)
    {
        $user = $event->user;
        $message =$event->message;
        $subject = $event->subject;
        $notification = UserNotificationSettings::where('user',$user->id)->first();
        if ($notification->account_activity == 1){
            $dataMail = [
                'subject'=>$subject,
                'name'=>$user->name,
                'line1'=>' ',
                'line2'=>$message,
                'last_line'=>'Remember, neither '.config('app.name').' nor her staff will ever ask you for your password nor
                your account/transaction pin. Remember to always reset your login details regularly to maintain high account security.'
            ];
            Notification::send($user, new SendAuthenticationMail($dataMail,3));
        }
    }
}
