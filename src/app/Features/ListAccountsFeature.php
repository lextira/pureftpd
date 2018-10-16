<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetAccountsJob;
use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class ListAccountsFeature extends Feature
{
    public function handle()
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $accounts = $this->run(GetAccountsJob::class, ['domainID' => $domainID]);

        return $this->run(new RespondWithJsonJob($accounts));
    }
}
