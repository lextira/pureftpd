<?php

namespace App\Console\Commands;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use Illuminate\Console\Command;

class FtpAccountAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:add {domain} {login} 
                                                {--dir=/} 
                                                {--desc=}
                                                {--pass=secret}
                                                {--status=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new account.';

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
        $domain = $this->domain->where('name', $this->argument('domain'))->first();

        if ($domain == null) {
            $this->error('Domain not found.');
            return false;
        }

        $account = $this->account->fill([
            'domain_id' => $domain->id,
            'login' => $this->argument('login'),
            'password' => $this->option('pass'),
            'status' => $this->option('status'),
            'relative_dir' => $this->option('dir'),
            'description' => $this->option('desc'),
        ]);

        if ( $this->account->where('login', $account->login)->exists() ) {
            $this->error('Account already exists.');
            return false;
        }

        $account->save();
        $this->info ('Account added.');
    }
}
