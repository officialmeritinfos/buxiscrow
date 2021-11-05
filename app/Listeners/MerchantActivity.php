<?php

namespace App\Listeners;

use App\Events\AccountActivity;
use App\Models\MerchantActivities;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MerchantActivity
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
     * @param  AccountActivity  $event
     * @return void
     */
    public function handle(AccountActivity $event)
    {
        $user = $event->user;
        if ($user->accountType == 1){
            MerchantActivities::create($event->message);
        }
    }
}
