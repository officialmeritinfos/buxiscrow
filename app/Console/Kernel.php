<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateBanks::class,
        Commands\SettleAccountFunding::class,
        Commands\UpdateAccountFunding::class,
        Commands\UpdateTransfer::class,
        Commands\EscrowExpired::class,
        Commands\UpdateMerchantPayout::class,
        Commands\RefundEscrow::class,
        Commands\CreditMerchant::class,
        Commands\DeliveryExpired::class,
        Commands\InspectionPeriodExpired::class,
        Commands\VerifyUserBvn::class,
        Commands\CreateAccountForUser::class,
        Commands\CheckSendMoneyStatus::class,
        Commands\SettleSendMoney::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('update:banks')->everyMinute()->withoutOverlapping();
        $schedule->command('settle:accountFunding')->everyMinute()->withoutOverlapping();
        $schedule->command('update:accountFunding')->everyMinute()->withoutOverlapping();
        $schedule->command('update:transfer')->everyMinute()->withoutOverlapping();
        $schedule->command('escrow:expired')->everyMinute()->withoutOverlapping();
        $schedule->command('update:merchantPayout')->everyMinute()->withoutOverlapping();
        $schedule->command('refund:escrow')->everyMinute()->withoutOverlapping();
        $schedule->command('credit:merchant')->everyMinute()->withoutOverlapping();
        $schedule->command('delivery:expired')->everyMinute()->withoutOverlapping();
        $schedule->command('inspectionPeriod:expired')->everyMinute()->withoutOverlapping();
        $schedule->command('verify:UserBvn')->everyMinute()->withoutOverlapping();
        $schedule->command('create:AccountForUser')->everyMinute()->withoutOverlapping();
        $schedule->command('check:sendMoneyStatus')->everyMinute()->withoutOverlapping();
        $schedule->command('settle:sendMoney')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
