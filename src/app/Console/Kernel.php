<?php

namespace App\Console;

use App\Console\Commands\FtpDomainAddCommand;
use App\Console\Commands\FtpDomainListCommand;
use App\Console\Commands\FtpDomainRmCommand;
use App\Console\Commands\FtpKeyGenerateCommand;
use App\Console\Commands\FtpKeyAddCommand;
use App\Console\Commands\FtpKeyListCommand;
use App\Console\Commands\FtpKeyRmCommand;
use App\Console\Commands\FtpUserAddCommand;
use App\Console\Commands\FtpUserListCommand;
use App\Console\Commands\FtpUserRmCommand;
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

        FtpUserAddCommand::class,
        FtpUserListCommand::class,
        FtpUserRmCommand::class,
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
