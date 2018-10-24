<?php

namespace App\Console\Commands;

use App\Data\Models\Key;
use Illuminate\Console\Command;

class FtpKeyRmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ftp:key:rm {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a key.';

    protected $key;

    /**
     * Create a new command instance.
     *
     * @param $key
     * @return void
     */
    public function __construct(Key $key)
    {
        parent::__construct();

        $this->key = $key;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( !$this->key->where('token', $this->argument('token'))->exists() ) {
            $this->error('There\'s no key with this token.');
            return false;
        }

        $this->key->where('token', $this->argument('token'))->delete();

        $this->info ('Key deleted.');
    }
}
