<?php
namespace App\Domains\Account\Jobs;

use App\Data\Repositories\Interfaces\AccountRepository;
use Lucid\Foundation\Job;

class GetAccountsJob extends Job
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
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function handle(AccountRepository $accountRepository)
    {
        return $accountRepository->paginate();
    }
}
