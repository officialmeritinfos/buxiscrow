<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Custom\RandomString;
use App\Events\EscrowNotification;
use App\Models\BankBanks;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class CreateAccountForUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:AccountForUser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Virtual account for user';

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
        $code = new RandomString(5);
        $users = User::where('hasBvn',1)->where('isVerified',1)->where('hasBank','!=',1)->get();
        if ($users->count()>0){
            foreach ($users as $user) {
                $tx_ref = $code->randomStr().date('dmYhis').mt_rand();
                $bvn = Crypt::decryptString($user->secret_id);
                $dataAccount = ['email'=>$user->email,'bvn'=>$bvn,'is_permanent'=>true,
                    'narration'=>$user->name,'tx_ref'=>$tx_ref];
                $createAccount = $gateway->createVirtualAccount($dataAccount);
                if ($createAccount->ok()){
                    $createAccount = $createAccount->json();
                    $createAccount = $createAccount['data'];
                    $dataBankAccount = [
                        'user'=>$user->id,
                        'Bank'=>$createAccount['bank_name'],
                        'Account_name'=>$user->name,
                        'Account_number'=>$createAccount['account_number'],
                        'bank_ref'=>$tx_ref,
                        'order_ref'=>$createAccount['order_ref']
                    ];
                    $dataUser = ['hasBank'=>1];
                    //add the account to database
                    $add = BankBanks::create($dataBankAccount);
                    if (!empty($add)){
                        User::where('id',$user->id)->update($dataUser);
                        $mail = 'A new bank account has been created for you. This is like your day to day bank account
                        and can be used to receive payment into your '.config('app.name').' account. Note that charges
                        applies on this account.' ;
                        //send a mail to the user
                        event(new EscrowNotification($user, $mail, 'New Bank Account on '.config('app.name')));
                    }
                }
            }
        }
    }
}
