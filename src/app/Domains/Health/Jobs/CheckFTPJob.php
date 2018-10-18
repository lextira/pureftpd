<?php
namespace App\Domains\Health\Jobs;

use Lucid\Foundation\Job;
use \FtpClient\FtpClient;

class CheckFTPJob extends Job
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
     * @param FtpClient $ftpClient
     * @return array
     */
    public function handle(FtpClient $ftpClient)
    {
        $response = [
            'ok' => false,
            'status' => 'Unknown error',
        ];
        try {
            $ftpClient->connect(config('ftp.url'));

            $response['ok'] = true;
            $response['status'] = 'OK';
        } catch (\Exception $e) {
            $response['status'] = $e->getMessage();
        }
        return $response;
    }
}
