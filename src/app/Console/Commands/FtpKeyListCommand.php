<?php

namespace App\Console\Commands;

use App\Domain;
use App\Key;
use Illuminate\Console\Command;

class FtpKeyListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:key:list {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List exiting keys of domain.';

    protected $domain;

    /**
     * Create a new command instance.
     *
     * @param $key
     * @param $domain
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
        $columns = ['id', 'created_at', 'token', 'description'];

        $domain = $this->domain->where('name', $this->argument('domain'))->first();

        if ($domain == null) {
            $this->error('Domain not found.');
            return false;
        }

        $keys = $domain->keys->transform(function ($item) use ($columns) {
            return $item->only($columns);
        });

        $this->table(
            $columns,
            $keys->toArray()
        );
    }
}
