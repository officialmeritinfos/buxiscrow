<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Models\AcceptedBanks;
use App\Models\CurrencyAccepted;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateBanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:banks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This updates the system Bank API';

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
        $currencies = CurrencyAccepted::where('status',1)->where('fetchNow',1)->where('hasBank',2)->get();
        //get the currency
        foreach ($currencies as $currency) {
            $gateWay = new FlutterWave();
            $banks = $gateWay->fetchBanks(strtoupper($currency->country));
            if ($banks->ok()){
                $banks=$banks->json();
                foreach ($banks['data'] as $datum) {
                    $dataBank = ['bankId'=>$datum['id'],'bankCode'=>$datum['code'], 'name'=>$datum['name'],
                        'country'=>strtoupper($currency->country),'currency'=>$currency->code
                    ];
                    $add = AcceptedBanks::create($dataBank);
                }
                if (!empty($add)){
                    $dataCurrency = ['hasBank'=>1];
                    CurrencyAccepted::where('id',$currency->id)->update($dataCurrency);
                }
            }else{
                Log::alert($banks);
            }
        }
    }
}
