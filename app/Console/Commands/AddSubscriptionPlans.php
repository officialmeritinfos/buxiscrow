<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Models\IntervalType;
use App\Models\PaymentLinks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AddSubscriptionPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:subscriptionPlans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $gateway = new FlutterWave();
        $subscriptions = PaymentLinks::where('type',2)->where('hasPlanId',2)->get();
        if ($subscriptions->count()>0){
            foreach ($subscriptions as $subscription) {
                //get the interval
                $interval = IntervalType::where('id',$subscription->intervals)->first();
                //lets get the data needed
                $dataPlan = ['amount'=>$subscription->amount,'name'=>$subscription->title,'interval'=>$interval->name,
                    'duration'=>$subscription->number_charge];
                $response = $gateway->createPlan($dataPlan);
                if ($response->ok()){
                    $response = $response->json();
                    $response = $response['data'];

                    //collate Date for Subscription update
                    $subData = ['planId'=>$response['id'],'planToken'=>$response['plan_token'],'hasPlanId'=>1];
                    PaymentLinks::where('id',$subscription->id)->update($subData);
                }
            }
        }
    }
}
