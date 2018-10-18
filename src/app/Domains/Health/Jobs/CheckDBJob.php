<?php
namespace App\Domains\Health\Jobs;

use App\Data\Repositories\Interfaces\AccountRepository;
use Lucid\Foundation\Job;

class CheckDBJob extends Job
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
     * @return array
     */
    public function handle(AccountRepository $accountRepository)
    {
        $response = [
            'ok' => false,
            'status' => 'Unknown error',
        ];
        try {
            $accountRepository->find(1);

            $response['ok'] = true;
            $response['status'] = 'OK';
        } catch (\Exception $e) {
            $response['status'] = $e->getMessage();
        }
        return $response;
    }
}
