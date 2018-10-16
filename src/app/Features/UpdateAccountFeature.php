<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Account\Jobs\UpdateAccountJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class UpdateAccountFeature extends Feature
{
    public function handle(Request $request)
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $request->merge(['domain_id' => $domainID]);
        $account = $this->run(UpdateAccountJob::class, ['domainID' => $domainID]);

        return $this->run(new RespondWithJsonJob($account));
    }
}
