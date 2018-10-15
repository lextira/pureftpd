<?php
namespace App\Features;

use App\Domains\Account\Jobs\UpdateAccountJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;

class UpdateAccountFeature extends Feature
{
    public function handle()
    {
        $account = $this->run(UpdateAccountJob::class);

        return $this->run(new RespondWithJsonJob($account));
    }
}
