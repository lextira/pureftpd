<?php
namespace App\Domains\Health\Tests\Jobs;

use App\Data\Models\Account;
use App\Data\Repositories\AccountRepositoryEloquent;
use App\Domains\Health\Jobs\CheckDBJob;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class CheckDBJobTest extends TestCase
{
    private $accountRepository;
    private $job;

    public function setUp()
    {
        parent::setUp();

        $this->accountRepository = \Mockery::mock(AccountRepositoryEloquent::class);
        $this->job = new CheckDBJob();
    }

    public function test_check_db_job()
    {
        $this->accountRepository->shouldReceive('first')->andReturn(new Account());

        $successResponse = [
            'ok' => true,
            'status' => 'OK',
        ];
        $this->assertEquals($successResponse, $this->job->handle($this->accountRepository));
    }

    public function test_check_db_job_empty_error()
    {
        $this->accountRepository->shouldReceive('first')->andReturn(null);

        $emptyResponse = [
            'ok' => false,
            'status' => 'No accounts found',
        ];
        $this->assertEquals($emptyResponse, $this->job->handle($this->accountRepository));
    }

    public function test_check_db_job_exception()
    {
        $exceptionMessage = 'Table doesn\'t exist';
        $this->accountRepository->shouldReceive('first')->andThrow(\Exception::class, $exceptionMessage);

        $exceptionResponse = [
            'ok' => false,
            'status' => $exceptionMessage,
        ];
        $this->assertEquals($exceptionResponse, $this->job->handle($this->accountRepository));
    }
}
