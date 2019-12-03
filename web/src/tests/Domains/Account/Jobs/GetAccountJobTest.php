<?php
namespace App\Domains\Account\Tests\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Models\Account;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Domains\Account\Jobs\GetAccountJob;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetAccountJobTest extends TestCase
{
    private $request;
    private $accountRepository;
    private $accountID = 123;
    private $domainID = 321;
    private $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->request =  \Mockery::mock(Request::class);
        $this->accountRepository = \Mockery::mock(AccountRepository::class);
        $this->account = new Account();
    }

    public function test_get_account_job()
    {
        $job = new GetAccountJob();

        $this->request->shouldReceive('route')->with('account')->andReturn($this->accountID);
        $this->accountRepository->shouldReceive('find')->with($this->accountID)->andReturn(new Account());

        $job->handle($this->request, $this->accountRepository);
    }

    public function test_get_account_job_with_domain()
    {
        $job = new GetAccountJob($this->domainID);

        $this->request->shouldReceive('route')->with('account')->andReturn($this->accountID);
        $this->accountRepository->shouldReceive('pushCriteria')
            ->with(\Mockery::on(function($argument) {
                return $argument instanceof DomainIDCriteria && $this->domainID == $argument->getDomainID();
            }))
            ->andReturn($this->accountRepository);
        $this->accountRepository->shouldReceive('find')->with($this->accountID)->andReturn($this->account);

        $this->assertEquals($this->account, $job->handle($this->request, $this->accountRepository));
    }
}
