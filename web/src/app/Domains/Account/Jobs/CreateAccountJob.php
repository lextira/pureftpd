<?php
namespace App\Domains\Account\Jobs;

use App\Data\Repositories\Interfaces\AccountRepository;
use App\Http\Requests\CreateAccountRequest;
use Lucid\Units\Job;

class CreateAccountJob extends Job
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
     * @param CreateAccountRequest $request
     * @param AccountRepository $accountRepository
     * @return mixed
     */
    public function handle(CreateAccountRequest $request, AccountRepository $accountRepository)
    {
        return $accountRepository->create(
            [
                'domain_id' => $request->input('domain_id'),
                'login' => $request->input('login'),
                'password' => $request->input('password'),
                'hashed_password' => $request->input('hashed_password'),
                'status' => $request->input('status', 1),
                'relative_dir' => $request->input('relative_dir'),
                'description' => $request->input('description'),
            ]
        );
    }
}
