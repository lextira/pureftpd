<?php
namespace App\Domains\Account\Jobs;

use App\Data\Models\Account;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Http\Requests\UpdateAccountRequest;
use Lucid\Foundation\Job;

class UpdateAccountJob extends Job
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
     * @param UpdateAccountRequest $request
     * @param AccountRepository $accountRepository
     * @return Account
     */
    public function handle(UpdateAccountRequest $request, AccountRepository $accountRepository)
    {
        return $accountRepository->update($request->all(), $request->route('account'));
    }
}
