<?php
namespace App\Domains\Account\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Repositories\Interfaces\AccountRepository;
use Lucid\Foundation\Job;

class GetAccountsJob extends Job
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
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function handle(AccountRepository $accountRepository)
    {
        if ($this->domainID) {
            $accountRepository->pushCriteria(new DomainIDCriteria($this->domainID));
        }
        if ($this->paginate) {
            return $accountRepository->paginate(null, $this->columns);
        } else {
            return $accountRepository->all($this->columns);
        }
    }
}
