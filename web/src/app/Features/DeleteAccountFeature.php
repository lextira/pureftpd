<?php
namespace App\Features;

use App\Domains\Account\Jobs\DeleteAccountJob;
use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;

class DeleteAccountFeature extends Feature
{
    public function handle()
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $account = $this->run(DeleteAccountJob::class, ['domainID' => $domainID]);

        return $this->run(new RespondWithJsonJob($account));
    }
}
