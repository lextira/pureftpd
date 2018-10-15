<?php

namespace App\Console\Commands;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use Illuminate\Console\Command;

class FtpAccountListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:account:list {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List existing accounts of a domain.';

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
        $columns = ['id', 'created_at', 'updated_at', 'login', 'status', 'relative_dir', 'description'];

        $domain = $this->domain->where('name', $this->argument('domain'))->first();

        if ($domain == null) {
            $this->error('Domain not found.');
            return false;
        }

        $accounts = $domain->accounts->transform(function ($item) use ($columns) {
            return $item->only($columns);
        });

        $this->table(
            $columns,
            $accounts->toArray()
        );
    }
}
