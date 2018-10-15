<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetAccountsJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class ListAccountsFeature extends Feature
{
    public function handle()
    {
        $accounts = $this->run(GetAccountsJob::class);

        return $this->run(new RespondWithJsonJob($accounts));
    }
}
