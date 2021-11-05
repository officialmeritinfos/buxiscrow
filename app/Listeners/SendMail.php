<?php

namespace App\Listeners;

use App\Events\SendWelcomeMail;
use App\Models\GeneralSettings;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendMail
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
     * @param  SendWelcomeMail  $event
     * @return void
     */
    public function handle(SendWelcomeMail $event)
    {
        $generalSettings = GeneralSettings::find(1);
        $user = $event->user;
        if ($user ->emailVerified ==1){
            $dataMail = [
                'subject'=>'Welcome to '.$generalSettings->siteName.' - Endless Opportunity' ,
                'name'=>$user->name,
                'line1'=>'Welcome to '.$generalSettings->siteName.'!<br> <p>People like you across Africa trust Us
                          with their online payments and we\'re happy that you\'re choosing us too. Our goal is to make
                          it easier and safer to buy online from your favourite retailers and make payments online in your
                          local African currencies.</p> <p>Not sure where to begin?</p>',
                'line2'=>'<ul style="list-style: circle;">
                            <li style="font-weight: bold;">Create an account</li>
                            <p>Create a '.$generalSettings->siteName.' account to start sending payments!</p>
                            <br>
                            <li style="font-weight: bold;">Fund it</li>
                            <p>
                                Fund your '.$generalSettings->siteName.' account by sending money directly from any account,card, using any of our
                                payment processors.
                            </p>
                            <br>
                            <li style="font-weight: bold;">Spend endlessly</li>
                            <p>Besides paying your favorite retailers, you can also send money to your family and friends with '.$generalSettings->siteName.'</p>
                            <br>
                        </ul>',
                'last_line'=>''
            ];
            Notification::send($user, new SendAuthenticationMail($dataMail,3));
        }
    }
}
