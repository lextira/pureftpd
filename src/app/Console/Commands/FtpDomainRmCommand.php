<?php

namespace App\Console\Commands;

use App\Domain;
use Illuminate\Console\Command;

class FtpDomainRmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:domain:rm {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a domain.';

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
        if ( !$this->domain->where('name', $this->argument('name'))->exists() ) {
            $this->error('There\'s no domain with this name.');
            return false;
        }

        $this->domain->where('name', $this->argument('name'))->delete();

        $this->info ('Domain deleted.');
    }
}
