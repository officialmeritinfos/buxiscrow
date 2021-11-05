<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\CurrencyAccepted;
use App\Models\MerchantBalances;
use App\Models\UserBalances;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;

class createBalance
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
        //check for the active account balances
        $currencies = CurrencyAccepted::where('status',1)->get();
        foreach ($currencies as $currency) {
                //get user's balance that corresponds to given code
                $userBalance = UserBalances::where('currency',$currency->code)->where('user',$user->id)->first();
                if (empty($userBalance)){
                    $dataBalance = [
                        'user'=>$user->id,
                        'currency'=>$currency->code,
                        'availableBalance'=>0,
                        'frozenBalance'=>0,
                        'referralBalance'=>0,
                        'TransactionLimit'=>$currency->unverifiedIndividualTransactionLimit,
                        'AccountLimit'=>$currency->unverifiedIndividualLimit,
                        'status'=>1
                    ];
                    UserBalances::create($dataBalance);
                }
                //get merchant's balance that corresponds to given code
                $merchantBalance = MerchantBalances::where('currency',$currency->code)->where('merchant',$user->id)->first();
                if (empty($merchantBalance)){
                    $dataBalance = [
                        'merchant'=>$user->id,
                        'balanceRef'=> Str::random('6').time(),
                        'currency'=>$currency->code,
                        'availableBalance'=>0,
                        'frozenBalance'=>0,
                        'referralBalance'=>0,
                        'TransactionLimit'=>$currency->unverifiedBusinessTransactionLimit,
                        'AccountLimit'=>$currency->unverifiedBusinessLimit,
                        'status'=>1
                    ];
                    MerchantBalances::create($dataBalance);
                }
        }
    }
}
