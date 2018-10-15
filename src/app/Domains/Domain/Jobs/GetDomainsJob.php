<?php
namespace App\Domains\Domain\Jobs;

use App\Data\Repositories\Interfaces\DomainRepository;
use Lucid\Foundation\Job;

class GetDomainsJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param DomainRepository $domainRepository
     * @return mixed
     */
    public function handle(DomainRepository $domainRepository)
    {
        return $domainRepository->paginate();
    }
}
