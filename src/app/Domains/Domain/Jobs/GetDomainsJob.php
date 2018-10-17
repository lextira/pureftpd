<?php
namespace App\Domains\Domain\Jobs;

use App\Data\Criteria\IDCriteria;
use App\Data\Repositories\Interfaces\DomainRepository;
use Lucid\Foundation\Job;

class GetDomainsJob extends Job
{
    protected $domainID;
    protected $paginate;
    protected $columns;

    /**
     * Create a new job instance.
     *
     * @param integer $domainID
     * @param bool $paginate
     * @param array $columns
     */
    public function __construct($domainID=null, $paginate=true, $columns=['*'])
    {
        $this->domainID = $domainID;
        $this->paginate = $paginate;
        $this->columns = $columns;
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
            return $domainRepository->paginate(null, $this->columns);
        } else {
            return $domainRepository->all($this->columns);
        }
    }
}
