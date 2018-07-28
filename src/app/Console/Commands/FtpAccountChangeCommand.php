<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FtpAccountChangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change an existing account.';

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
