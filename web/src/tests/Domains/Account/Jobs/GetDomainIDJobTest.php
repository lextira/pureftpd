<?php
namespace App\Domains\Account\Tests\Jobs;

use App\Data\Models\Account;
use App\Domains\Account\Jobs\GetDomainIDJob;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetDomainIDJobTest extends TestCase
{
    private $request;
    private $auth;
    private $domainID = 123;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = \Mockery::mock(Request::class);
        $this->auth = \Mockery::mock(Guard::class);
    }

    public function test_get_domain_id_job()
    {
        $job = new GetDomainIDJob();

        $this->auth->shouldReceive('check')->with()->andReturn(false);
        $this->request->shouldReceive('input')->with('domain_id')->andReturn(null);

        $this->assertNull($job->handle($this->request, $this->auth));
    }

    public function test_get_domain_id_job_with_auth()
    {
        $job = new GetDomainIDJob();

        $this->auth->shouldReceive('check')->with()->andReturn(true);
        $this->auth->shouldReceive('user')->with()->andReturn(new Account([
            'domain_id' => $this->domainID,
        ]));

        $this->assertEquals($this->domainID, $job->handle($this->request, $this->auth));
    }

    public function test_get_domain_id_job_with_input()
    {
        $job = new GetDomainIDJob();

        $this->auth->shouldReceive('check')->with()->andReturn(false);
        $this->request->shouldReceive('input')->with('domain_id')->andReturn($this->domainID);

        $this->assertEquals($this->domainID, $job->handle($this->request, $this->auth));
    }
}
