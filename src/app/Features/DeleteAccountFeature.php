<?php
namespace App\Features;

use App\Domains\Account\Jobs\DeleteAccountJob;
use Lucid\Foundation\Feature;

class DeleteAccountFeature extends Feature
{
    public function handle()
    {
        $account = $this->run(DeleteAccountJob::class);

        return $this->run(new RespondWithJsonJob($account));
    }
}
