<?php
namespace App\Features;

use App\Domains\Domain\Jobs\GetDomainsJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class ListDomainsFeature extends Feature
{
    public function handle(Request $request)
    {
        $domains = $this->run(GetDomainsJob::class);

        return $this->run(new RespondWithJsonJob($domains));
    }
}
