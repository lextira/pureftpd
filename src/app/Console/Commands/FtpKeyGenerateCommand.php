<?php

namespace App\Console\Commands;

use App\Domain;
use App\Key;
use Illuminate\Console\Command;

class FtpKeyGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:key:generate {domain} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new key.';

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
        $domain = $this->domain->where('name', $this->argument('domain'))->first();

        if ($domain == null) {
            $this->error('Domain not found.');
            return false;
        }

        $key = $this->key->create([
            'domain_id' => $domain->id,
            'token' => str_random(64),
            'description' => $this->argument('description')
        ]);

        $this->info ('Key generated and added. Token: '. $key->token);
    }
}
