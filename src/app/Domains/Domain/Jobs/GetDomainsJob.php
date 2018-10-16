<?php
namespace App\Domains\Domain\Jobs;

use App\Data\Criteria\IDCriteria;
use App\Data\Repositories\Interfaces\DomainRepository;
use Lucid\Foundation\Job;

class GetDomainsJob extends Job
{
    protected $domainID;
    protected $paginate;

    /**
     * Create a new job instance.
     *
     * @param integer $domainID
     * @param bool $paginate
     */
    public function __construct($domainID=null, $paginate=true)
    {
        $this->domainID = $domainID;
        $this->paginate = $paginate;
    }

    /**
     * Execute the job.
     *
     * @param DomainRepository $domainRepository
     * @return mixed
     */
    public function handle(DomainRepository $domainRepository)
    {
        if ($this->domainID) {
            $domainRepository->pushCriteria(new IDCriteria($this->domainID));
        }
        if ($this->paginate) {
            return $domainRepository->paginate();
        } else {
            return $domainRepository->all();
        }
    }
}
