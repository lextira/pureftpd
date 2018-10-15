<?php
namespace App\Domains\Account\Jobs;

use App\Data\Repositories\Interfaces\AccountRepository;
use Illuminate\Http\Request;
use Lucid\Foundation\Job;

class GetAccountJob extends Job
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
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function handle(Request $request, AccountRepository $accountRepository)
    {
        return $accountRepository->find($request->route('account'));
    }
}
