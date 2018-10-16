<?php
namespace App\Domains\Account\Jobs;

use Lucid\Foundation\Job;

class GetDomainIDJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $domainID = null;
        if (auth()->check() && isset(auth()->user()->domain_id)) {
            $domainID = auth()->user()->domain_id;
        }

        return $domainID;
    }
}
