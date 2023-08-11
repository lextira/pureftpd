<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetAccountJob;
use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class ShowAccountFeature extends Feature
{
    public function handle()
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $account = $this->run(GetAccountJob::class, ['domainID' => $domainID]);

        return $this->run(new RespondWithJsonJob($account));
    }
}
