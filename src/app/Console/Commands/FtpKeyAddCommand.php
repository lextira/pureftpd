<?php

namespace App\Console\Commands;

use App\Domain;
use App\Key;
use Illuminate\Console\Command;

class FtpKeyAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:key:add {domain} {token} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new key.';

    protected $key;
    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param $key
     * @param $domain
     * @return void
     */
    public function __construct(Key $key, Domain $domain)
    {
        parent::__construct();

        $this->key = $key;
        $this->domain = $domain;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( $this->key->where('token', $this->argument('token'))->exists() ) {
            $this->error('Key already exists.');
            return false;
        }

        $domain = $this->domain->where('name', $this->argument('domain'))->first();

        if ($domain == null) {
            $this->error('Domain not found.');
            return false;
        }

        $this->key->create([
            'domain_id' => $domain->id,
            'token' => $this->argument('token'),
            'description' => $this->argument('description')
        ]);

        $this->info ('Key added.');
        if ( strlen( $this->argument('token') ) <  64 ) {
            $this->comment('Keys should be at least 64 characters long.');
        }
    }
}
