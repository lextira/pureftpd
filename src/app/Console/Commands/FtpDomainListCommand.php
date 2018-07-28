<?php

namespace App\Console\Commands;

use App\Domain;
use Illuminate\Console\Command;

class FtpDomainListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:domain:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List existing domains.';

    /**
     * @var Domain
     */
    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param Domain $domain
     * @return void
     */
    public function __construct(Domain $domain)
    {
        parent::__construct();

        $this->domain = $domain;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $columns = ['id', 'name', 'created_at'];

        $this->table(
            $columns,
            $this->domain->all($columns)->toArray()
        );
    }
}
