<?php
namespace App\Features;

use App\Domains\Account\Jobs\CreateAccountJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class CreateAccountFeature extends Feature
{
    public function handle()
    {
        $account = $this->run(CreateAccountJob::class);

        return $this->run(new RespondWithJsonJob($account));
    }
}
