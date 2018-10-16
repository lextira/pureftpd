<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Domain\Jobs\GetDomainsJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class ListDomainsFeature extends Feature
{
    public function handle(Request $request)
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $params = [
            'domainID' => $domainID,
            'paginate' => $request->input('paginate', true),
            'columns' => $request->input('columns', ['*']),
        ];
        $domains = $this->run(GetDomainsJob::class, $params);

        return $this->run(new RespondWithJsonJob($domains));
    }
}
