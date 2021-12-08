<?php

namespace App\Console\Commands;

use App\Custom\FlutterWave;
use App\Events\EscrowNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class VerifyUserBvn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verify:UserBvn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies Users BVN';

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
        $users = User::where('hasBvn',1)->where('isVerified',4)->get();
        foreach ($users as $user) {
            $gateway = new FlutterWave();
            //verify bvn
            $bvn = Crypt::decryptString($user->secret_id);
            $bvnData = $gateway->verifyBvn($bvn);
            if ($bvnData->ok()){
                $bvnData = $bvnData->json();
                $bvnData = $bvnData['data'];
                //verify the date of birth
                if ($user->hasDob ==1){

                    $submittedDob = strtotime($user->DOB);
                    $bvnDob = strtotime($bvnData['date_of_birth']);
                    if ($submittedDob == $bvnDob){
                        $dataUser = ['isVerified'=>1,'Gender'=>$bvnData['gender']];
                        $mail = 'Your account has been verified. You can now request for account Limit Upgrade.';
                    }else{
                        $dataUser = ['isVerified'=>3,'VerificationError'=>'Mismatched Date of birth'];
                        $mail = 'We could not verifiy your account due to some reasons. Check your account for more information';
                    }
                    //update Account
                    $update = User::where('id',$user->id)->update($dataUser);
                    if ($update){
                        event(new EscrowNotification($user, $mail, 'Account Verification'));
                    }
                }
            }
        }
    }
}
