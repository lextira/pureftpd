<?php
namespace App\Domains\Account\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Models\Account;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Http\Requests\UpdateAccountRequest;
use Lucid\Foundation\Job;

class UpdateAccountJob extends Job
{
    protected $domainID;

    /**
     * Create a new job instance.
     *
     * @param null $domainID
     */
    public function __construct($domainID=null)
    {
        $this->domainID = $domainID;
    }

    /**
     * Execute the job.
     *
     * @param UpdateAccountRequest $request
     * @param AccountRepository $accountRepository
     * @return Account
     */
    public function handle(UpdateAccountRequest $request, AccountRepository $accountRepository)
    {
        if ($this->domainID) {
            $accountRepository->pushCriteria(new DomainIDCriteria($this->domainID));
        }
        return $accountRepository->updateWithCriteria($request->all(), $request->route('account'));
    }
}
