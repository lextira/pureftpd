<?php
namespace App\Domains\Account\Tests\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Models\Account;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Domains\Account\Jobs\GetAccountsJob;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetAccountsJobTest extends TestCase
{
    private $accountRepository;
    private $domainID = 321;
    private $columns = ['id', 'login'];
    private $accounts;

    public function setUp()
    {
        parent::setUp();

        $this->accountRepository = \Mockery::mock(AccountRepository::class);
        $this->accounts = [
            new Account(),
            new Account(),
        ];
    }

    public function test_get_accounts_job()
    {
        $job = new GetAccountsJob(null, true, $this->columns);

        $this->accountRepository->shouldReceive('paginate')->with(null, $this->columns)->andReturn($this->accounts);

        $this->assertEquals($this->accounts, $job->handle($this->accountRepository));
    }

    public function test_get_accounts_job_with_domain()
    {
        $job = new GetAccountsJob($this->domainID, false, $this->columns);

        $this->accountRepository->shouldReceive('pushCriteria')
            ->with(\Mockery::on(function($argument) {
                return $argument instanceof DomainIDCriteria && $this->domainID == $argument->getDomainID();
            }))
            ->andReturn($this->accountRepository);

        $this->accountRepository->shouldReceive('all')->with($this->columns)->andReturn($this->accounts);

        $this->assertEquals($this->accounts, $job->handle($this->accountRepository));
    }
}
