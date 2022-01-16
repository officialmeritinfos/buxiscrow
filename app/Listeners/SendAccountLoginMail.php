<?php

namespace App\Listeners;

use App\Custom\Regular;
use App\Events\LoginMail;
use App\Models\GeneralSettings;
use App\Models\Logins;
use App\Models\MerchantLogins;
use App\Models\UserNotificationSettings;
use App\Notifications\SendAuthenticationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendAccountLoginMail
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
     * @param  LoginMail  $event
     * @return void
     */
    public function handle(LoginMail $event)
    {
        $generalSettings = GeneralSettings::find(1);
        $user = $event->user;
        $ip=$event->ip;
        //get the user's country
        $ipDetector = new Regular();
        $agent = $ipDetector->getUserAgent($ip);
        $agents = $ipDetector->getUserCountry($ip);
        $location = $agent->json();
        $locations = $agents->json();
        $userIp = $ip;
        /*$userLocation = $locations['city'].','.$locations['state_prov'].','.$locations['country_name'];
        $dataLogin = [
            'user'=>$user->id,
            'loginIp'=>$userIp,
            'agent'=>$_SERVER['HTTP_USER_AGENT'],
            'location'=>$userLocation,
            'isp'=>$locations['isp']
        ];*/
        $userNotification = UserNotificationSettings::where('user',$user->id)->first();
        if ($user->emailVerified ==1){
            if($userNotification->login_notification == 1) {
                //($user->accountType == 2) ? Logins::create($dataLogin) : MerchantLogins::create($dataLogin);
                $dataMail = [
                    'subject' => 'Login Notification',
                    'name' => $user->name,
                    'line1' => 'Your ' . config('app.name') . ' account was currently accessed on ' . date('d-m- Y h:i:s a'),
                    'line2' => 'If this access was not you, kindly reset your login details or contact our support center immediately.',
                    'last_line' => 'Details are as follows: <br> ISP: ' . $locations['isp'] . '<br> IP:
                                <b>' . $userIp . '</b> <br> Location :<b>' . $userLocation . '</b>'
                ];
                Notification::send($user, new SendAuthenticationMail($dataMail, 3));
            }
        }
    }
}
