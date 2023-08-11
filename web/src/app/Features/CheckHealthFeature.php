<?php
namespace App\Features;

use App\Domains\Health\Jobs\CheckDBJob;
use App\Domains\Health\Jobs\CheckFTPJob;
use App\Domains\Health\Jobs\CheckSSLJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Units\Feature;
use Illuminate\Http\Request;

class CheckHealthFeature extends Feature
{
    public function handle(Request $request)
    {
        $dbCheckResult = $this->run(CheckDBJob::class);
        $ftpCheckResult = $this->run(CheckFTPJob::class);
        $sslCheckResult = $this->run(CheckSSLJob::class);

        if ($dbCheckResult['ok'] && $ftpCheckResult['ok'] && $sslCheckResult['ok']) {
            $status = 200;
        } else {
            $status = 500;
        }

        $result = [
            'db_status' => $dbCheckResult['status'],
            'ftp_status' => $ftpCheckResult['status'],
            'ssl_status' => $sslCheckResult['status']
        ];
        return $this->run(new RespondWithJsonJob($result, $status));
    }
}
