<?php
namespace App\Domains\Health\Tests\Jobs;

use App\Domains\Health\Jobs\CheckFTPJob;
use FtpClient\FtpClient;
use Tests\TestCase;

class CheckFTPJobTest extends TestCase
{
    private $ftpClient;
    private $job;

    public function setUp(): void
    {
        parent::setUp();

        $this->ftpClient = \Mockery::mock(FtpClient::class);
        $this->job = new CheckFTPJob();
    }

    public function test_check_ftp_job()
    {
        $this->ftpClient->shouldReceive('connect')->with(config('ftp.url'))->andReturn();
        $successResponse = [
            'ok' => true,
            'status' => 'OK',
        ];
        $this->assertEquals($successResponse, $this->job->handle($this->ftpClient));
    }

    public function test_check_ftp_job_exception()
    {
        $exceptionMessage = 'Can\'t connect';
        $this->ftpClient->shouldReceive('connect')
            ->with(config('ftp.url'))
            ->andThrow(\Exception::class, $exceptionMessage);
        $exceptionResponse = [
            'ok' => false,
            'status' => $exceptionMessage,
        ];
        $this->assertEquals($exceptionResponse, $this->job->handle($this->ftpClient));
    }
}
