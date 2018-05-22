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
        Commands\Jihua::class,
        Commands\ClickM::class,
        Commands\ClickH::class,
        Commands\ClickD::class,
        Commands\PvM::class,
        Commands\PvH::class,
        Commands\PvD::class,
        Commands\MoneyD::class,
        Commands\MoneyW::class,
        //统计
        Commands\StatDataPv::class,
        Commands\StatDataPc::class,
        Commands\MobileM::class,
        //Commands\MobileD::class,

        Commands\NewEarningHour::class,
        Commands\NewEarningDay::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('clickm')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
