<?php
namespace App\Domains\Health\Jobs;

use Carbon\Carbon;
use Lucid\Foundation\Job;
use Spatie\SslCertificate\SslCertificate;

class CheckSSLJob extends Job
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
     * @return void
     */
    public function handle()
    {
        $response = [
            'ok' => false,
            'status' => 'Unknown error',
        ];
        try {
            $certificate = $this->getCertificate(config('app.url'));
            $expiration = $certificate->expirationDate();
            $days = Carbon::now()->diffInDays($expiration, false);
            if ($days > config('ftp.ssl_expiration')) {
                $response['ok'] = true;
                $response['status'] = 'OK';
            } else {
                if ($days == 0) {
                    $response['status'] = 'Certificate expires today';
                } else if ($days == 1) {
                    $response['status'] = 'Certificate expires tomorrow';
                } else if ($days > 1) {
                    $response['status'] = 'Certificate expires in ' . $days . ' days';
                } else {
                    $response['status'] = 'Certificate has been expired';
                }
            }
        } catch (\Exception $e) {
            $response['status'] = $e->getMessage();
        }
        return $response;
    }

    protected function getCertificate($url)
    {
        return SslCertificate::createForHostName($url);
    }
}
