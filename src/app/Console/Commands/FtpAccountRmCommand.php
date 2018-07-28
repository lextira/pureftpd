<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FtpAccountRmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:rm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an account.';

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
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
