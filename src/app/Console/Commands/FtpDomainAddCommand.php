<?php

namespace App\Console\Commands;

use App\Data\Models\Domain;
use Illuminate\Console\Command;

/**
 * Class FtpDomainAddCommand
 * @package App\Console\Commands
 */
class FtpDomainAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:domain:add {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new domain.';

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
        if ( $this->domain->where('name', $this->argument('name'))->exists() ) {
            $this->error('Domain already exists.');
            return false;
        }

        $this->domain->create([
            'name' => $this->argument('name')
        ]);

        $this->info ('Domain created.');
    }
}
