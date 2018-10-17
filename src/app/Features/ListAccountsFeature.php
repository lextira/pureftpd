<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetAccountsJob;
use App\Domains\Account\Jobs\GetDomainIDJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Http\Request;
use Lucid\Foundation\Feature;

class ListAccountsFeature extends Feature
{
    public function handle(Request $request)
    {
        $domainID = $this->run(GetDomainIDJob::class);
        $params = [
            'domainID' => $domainID,
            'paginate' => $request->input('paginate', true),
            'columns' => $request->input('columns', ['*']),
        ];
        $accounts = $this->run(GetAccountsJob::class, $params);

        return $this->run(new RespondWithJsonJob($accounts));
    }
}
