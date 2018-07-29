<?php

namespace App\Console\Commands;

use App\Account;
use App\Domain;
use Illuminate\Console\Command;

class FtpAccountRmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:rm {login}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an account.';

    protected $account;
    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param $account
     * @param $domain
     * @return void
     */
    public function __construct(Account $account, Domain $domain)
    {
        parent::__construct();

        $this->account = $account;
        $this->domain = $domain;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( !$this->account->where('login', $this->argument('login'))->exists() ) {
            $this->error('There\'s no account with this login.');
            return false;
        }

        $this->account->where('login', $this->argument('login'))->delete();

        $this->info ('Account deleted.');
    }
}
