<?php
namespace App\Domains\Account\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Repositories\Interfaces\AccountRepository;
use Illuminate\Http\Request;
use Lucid\Foundation\Job;

class GetAccountJob extends Job
{
    protected $domainID;

    /**
     * Create a new job instance.
     *
     * @param integer $domainID
     */
    public function __construct($domainID=null)
    {
        $this->domainID = $domainID;
    }

    /**
     * Execute the job.
     *
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function handle(Request $request, AccountRepository $accountRepository)
    {
        if ($this->domainID) {
            $accountRepository->pushCriteria(new DomainIDCriteria($this->domainID));
        }
        return $accountRepository->find($request->route('account'));
    }
}
