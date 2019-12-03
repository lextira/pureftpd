<?php
namespace App\Domains\Domain\Tests\Jobs;

use App\Data\Criteria\IDCriteria;
use App\Data\Models\Domain;
use App\Data\Repositories\Interfaces\DomainRepository;
use App\Domains\Domain\Jobs\GetDomainsJob;
use Tests\TestCase;

class GetDomainsJobTest extends TestCase
{
    private $domainRepository;
    private $columns = ['id', 'name'];
    private $domains;
    private $domainID;

    public function setUp(): void
    {
        parent::setUp();

        $this->domainRepository = \Mockery::mock(DomainRepository::class);
        $this->domains = [
            new Domain(),
            new Domain(),
        ];
    }

    public function test_get_domains_job()
    {
        $job = new GetDomainsJob(null, true, $this->columns);

        $this->domainRepository->shouldReceive('paginate')->with(null, $this->columns)->andReturn($this->domains);

        $this->assertEquals($this->domains, $job->handle($this->domainRepository));
    }

    public function test_get_domains_job_with_id()
    {
        $job = new GetDomainsJob($this->domainID, false, $this->columns);

        $this->domainRepository->shouldReceive('all')->with($this->columns)->andReturn($this->domains);

        $this->domainRepository->shouldReceive('pushCriteria')
            ->with(\Mockery::on(function($argument) {
                return $argument instanceof IDCriteria && $this->domainID == $argument->getID();
            }))
            ->andReturn($this->domainRepository);

        $this->assertEquals($this->domains, $job->handle($this->domainRepository));
    }
}
