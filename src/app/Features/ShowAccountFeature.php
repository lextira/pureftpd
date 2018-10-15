<?php
namespace App\Features;

use App\Domains\Account\Jobs\GetAccountJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class ShowAccountFeature extends Feature
{
    public function handle()
    {
        $account = $this->run(GetAccountJob::class);

        return $this->run(new RespondWithJsonJob($account));
    }
}
