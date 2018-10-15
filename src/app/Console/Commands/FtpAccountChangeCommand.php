<?php

namespace App\Console\Commands;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use Illuminate\Console\Command;

class FtpAccountChangeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:change {login}
                                                {--dir=/} 
                                                {--desc=}
                                                {--pass=secret}
                                                {--status=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change an existing account.';

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
        $account = $this->account->where('login', $this->argument('login'))->first();

        if ($account == null) {
            $this->error('Account not found.');

            return false;
        }

        $account->fill([
            'password' => $this->option('pass'),
            'status' => $this->option('status'),
            'relative_dir' => $this->option('dir'),
            'description' => $this->option('desc'),
        ])->save();
    }
}
