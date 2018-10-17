<?php
namespace App\Domains\Account\Tests\Jobs;

use App\Data\Criteria\DomainIDCriteria;
use App\Data\Models\Account;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Domains\Account\Jobs\UpdateAccountJob;
use App\Http\Requests\UpdateAccountRequest;
use Tests\TestCase;

class UpdateAccountJobTest extends TestCase
{
    private $request;
    private $accountRepository;
    private $data = [
        'domain_id' => 1,
        'login' => 'login',
        'password' => 'pass',
        'status' => 1,
        'relative_dir' => 'dir',
        'description' => 'desc',
    ];
    private $accountID = 123;
    private $domainID = 321;
    private $account;

    public function setUp()
    {
        parent::setUp();

        $this->request =  \Mockery::mock(UpdateAccountRequest::class);
        $this->accountRepository = \Mockery::mock(AccountRepository::class);
        $this->account = new Account();
    }

    public function test_update_account_job()
    {
        $job = new UpdateAccountJob();

        $this->request->shouldReceive('all')->with()->andReturn($this->data);
        $this->request->shouldReceive('route')->with('account')->andReturn($this->accountID);
        $this->accountRepository->shouldReceive('updateWithCriteria')
            ->with($this->data, $this->accountID)
            ->andReturn($this->account);

        $this->assertEquals($this->account, $job->handle($this->request, $this->accountRepository));
    }

    public function test_update_account_job_with_domain()
    {
        $job = new UpdateAccountJob($this->domainID);

        $this->request->shouldReceive('all')->with()->andReturn($this->data);
        $this->request->shouldReceive('route')->with('account')->andReturn($this->accountID);
        $this->accountRepository->shouldReceive('pushCriteria')
            ->with(\Mockery::on(function($argument) {
                return $argument instanceof DomainIDCriteria && $this->domainID == $argument->getDomainID();
            }))
            ->andReturn($this->accountRepository);
        $this->accountRepository->shouldReceive('updateWithCriteria')
            ->with($this->data, $this->accountID)
            ->andReturn($this->account);

        $this->assertEquals($this->account, $job->handle($this->request, $this->accountRepository));
    }
}
