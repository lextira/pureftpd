<?php
namespace App\Domains\Account\Jobs;

use Illuminate\Http\Request;
use Lucid\Foundation\Job;
use Illuminate\Contracts\Auth\Guard;

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
     * @param Request $request
     * @param Guard $auth
     * @return void
     */
    public function handle(Request $request, Guard $auth)
    {
        $domainID = null;
        if ($auth->check() && isset($auth->user()->domain_id)) {
            $domainID = $auth->user()->domain_id;
        } else {
            $domainID = $request->input('domain_id');
        }

        return $domainID;
    }
}
