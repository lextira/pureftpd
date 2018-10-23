<?php
namespace App\Domains\Health\Tests\Jobs;

use App\Domains\Health\Jobs\CheckSSLJob;
use Carbon\Carbon;
use Spatie\SslCertificate\SslCertificate;
use Tests\TestCase;

class CheckSSLJobTest extends TestCase
{
    private $sslCertificate;
    private $job;

    public function setUp()
    {
        parent::setUp();

        $this->sslCertificate = \Mockery::mock(SslCertificate::class);
        $this->job = \Mockery::mock(CheckSSLJob::class)
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
    }

    public function test_check_ssl_job()
    {
        $expirationDate = Carbon::now()->addDays(config('ftp.ssl_expiration') + 1);
        $this->sslCertificate->shouldReceive('expirationDate')->andReturn($expirationDate);
        $this->job->shouldReceive('getCertificate')->andReturn($this->sslCertificate);
        $successResponse = [
            'ok' => true,
            'status' => 'OK',
        ];
        $this->assertEquals($successResponse, $this->job->handle());
    }

    public function test_check_ssl_job_expire_soon()
    {
        $expirationDate = Carbon::now()->addDays(config('ftp.ssl_expiration'));
        $this->sslCertificate->shouldReceive('expirationDate')->andReturn($expirationDate);
        $this->job->shouldReceive('getCertificate')->andReturn($this->sslCertificate);
        $expiresResponse = [
            'ok' => false,
            'status' => 'Certificate expires in ' . config('ftp.ssl_expiration') . ' days',
        ];
        $this->assertEquals($expiresResponse, $this->job->handle());
    }

    public function test_check_ssl_job_exception()
    {
        $exceptionMessage = 'Can\'t get certificate';
        $this->job->shouldReceive('getCertificate')->andThrow(\Exception::class, $exceptionMessage);;
        $exceptionResponse = [
            'ok' => false,
            'status' => $exceptionMessage,
        ];
        $this->assertEquals($exceptionResponse, $this->job->handle());
    }
}
