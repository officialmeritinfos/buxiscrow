<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\UserNotificationSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserNotification
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
        $user = $event->user;
        $dataNotification = ['user'=>$user->id,'login_notification'=>1,'news_letters'=>2,'account_activity'=>1];
        UserNotificationSettings::create($dataNotification);
    }
}
