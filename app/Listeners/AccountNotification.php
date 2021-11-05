<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Models\UserNotificationSettings;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class AccountNotification
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
     * @param  SendNotification  $event
     * @return void
     */
    public function handle(SendNotification $event)
    {
        $user = $event->user;
        $message =$event->message;
        $type = $event->type;
        $notification = UserNotificationSettings::where('user',$user->id)->first();
        if ($notification->account_activity == 1){
            $dataMail = [
                'subject'=>'Account Notification',
                'name'=>$user->name,
                'line1'=>'An activity was currently performed on your '.config('app.name').' account. Find Details below:',
                'line2'=>$message,
                'last_line'=>'Remember, neither '.config('app.name').' nor her staff will ever ask you for your password nor
                your account/transaction pin. Remember to always reset your login details regularly to maintain high account security.'
            ];
            Notification::send($user, new SendAuthenticationMail($dataMail,3));
        }
    }
}
