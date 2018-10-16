<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Domain\Jobs\GetDomainsJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class ListDomainsFeature extends Feature
{
    public function handle()
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $domains = $this->run(GetDomainsJob::class, ['domainID' => $domainID]);

        return $this->run(new RespondWithJsonJob($domains));
    }
}
