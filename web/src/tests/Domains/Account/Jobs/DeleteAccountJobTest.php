<?php
namespace App\Domains\Account\Tests\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Domains\Account\Jobs\DeleteAccountJob;
use Illuminate\Http\Request;
use Tests\TestCase;

class DeleteAccountJobTest extends TestCase
{
    private $request;
    private $accountRepository;
    private $accountID = 123;
    private $domainID = 321;

    public function setUp()
    {
        parent::setUp();

        $this->request =  \Mockery::mock(Request::class);
        $this->accountRepository = \Mockery::mock(AccountRepository::class);
    }

    public function test_delete_account_job()
    {
        $job = new DeleteAccountJob();

        $this->request->shouldReceive('route')->with('account')->andReturn($this->accountID);
        $this->accountRepository->shouldReceive('delete')->with($this->accountID)->andReturn($this->accountID);

        $job->handle($this->request, $this->accountRepository);
    }

    public function test_delete_account_job_with_domain()
    {
        $job = new DeleteAccountJob($this->domainID);

        $this->request->shouldReceive('route')->with('account')->andReturn($this->accountID);

        $this->accountRepository->shouldReceive('pushCriteria')
            ->with(\Mockery::on(function($argument) {
                return $argument instanceof DomainIDCriteria && $this->domainID == $argument->getDomainID();
            }))
            ->andReturn($this->accountRepository);

        $this->accountRepository->shouldReceive('delete')->with($this->accountID)->andReturn($this->accountID);

        $this->assertEquals($this->accountID, $job->handle($this->request, $this->accountRepository));
    }
}
