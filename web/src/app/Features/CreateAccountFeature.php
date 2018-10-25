<?php
namespace App\Features;

use App\Domains\Account\Jobs\CreateAccountJob;
use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class CreateAccountFeature extends Feature
{
    public function handle(Request $request)
    {
        $domainID = $this->run(GetDomainIDJob::class);
        if ($domainID) {
            $request->merge(['domain_id' => $domainID]);
        }
        $account = $this->run(CreateAccountJob::class);

        return $this->run(new RespondWithJsonJob($account));
    }
}
