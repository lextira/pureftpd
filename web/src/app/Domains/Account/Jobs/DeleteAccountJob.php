<?php
namespace App\Domains\Account\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Repositories\Interfaces\AccountRepository;
use Illuminate\Http\Request;
use Lucid\Units\Job;

class DeleteAccountJob extends Job
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
     * @return int
     */
    public function handle(Request $request, AccountRepository $accountRepository)
    {
        if ($this->domainID) {
            $accountRepository->pushCriteria(new DomainIDCriteria($this->domainID));
        }
        return $accountRepository->delete($request->route('account'));
    }
}
