<?php

namespace App\Console;

use App\Console\Commands\FtpAccountAddCommand;
use App\Console\Commands\FtpAccountChangeCommand;
use App\Console\Commands\FtpAccountListCommand;
use App\Console\Commands\FtpAccountRmCommand;
use App\Console\Commands\FtpDomainAddCommand;
use App\Console\Commands\FtpDomainListCommand;
use App\Console\Commands\FtpDomainRmCommand;
use App\Console\Commands\FtpKeyGenerateCommand;
use App\Console\Commands\FtpKeyAddCommand;
use App\Console\Commands\FtpKeyListCommand;
use App\Console\Commands\FtpKeyRmCommand;
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
        FtpDomainAddCommand::class,
        FtpDomainListCommand::class,
        FtpDomainRmCommand::class,

        FtpKeyAddCommand::class,
        FtpKeyGenerateCommand::class,
        FtpKeyListCommand::class,
        FtpKeyRmCommand::class,

        FtpAccountAddCommand::class,
        FtpAccountListCommand::class,
        FtpAccountChangeCommand::class,
        FtpAccountRmCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
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
