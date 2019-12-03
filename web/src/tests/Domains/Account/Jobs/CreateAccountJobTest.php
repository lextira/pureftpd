<?php
namespace App\Domains\Account\Tests\Jobs;

use App\Data\Models\Account;
use App\Data\Repositories\Interfaces\AccountRepository;
use App\Domains\Account\Jobs\CreateAccountJob;
use App\Http\Requests\CreateAccountRequest;
use Tests\TestCase;

class CreateAccountJobTest extends TestCase
{
    private $job;
    private $request;
    private $accountRepository;
    private $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->request =  \Mockery::mock(CreateAccountRequest::class);
        $this->accountRepository = \Mockery::mock(AccountRepository::class);

        $this->job = new CreateAccountJob();
        $this->account = new Account();
    }

    public function test_create_account_job()
    {
        $data = [
            'domain_id' => 1,
            'login' => 'login',
            'password' => 'pass',
            'hashed_password' => null,
            'status' => 1,
            'relative_dir' => 'dir',
            'description' => 'desc',
        ];
        foreach ($data as $field => $val) {
            if ($field == 'status') {
                $this->request->shouldReceive('input')->with($field, $val)->andReturn($val);
            } else {
                $this->request->shouldReceive('input')->with($field)->andReturn($val);
            }

        }
        $this->accountRepository->shouldReceive('create')->with($data)->andReturn($this->account);

        $this->assertEquals($this->account, $this->job->handle($this->request, $this->accountRepository));
    }
}
