<?php
namespace App\Domains\Http\Tests\Jobs;

use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Routing\ResponseFactory;
use Tests\TestCase;

class RespondWithJsonJobTest extends TestCase
{
    private $content = ['data' => ['Test']];
    private $status = 600;
    private $headers = ['Content-Type' => 'application/json'];
    private $options = 1;
    private $responseFactory;
    private $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->responseFactory = \Mockery::mock(ResponseFactory::class);
        $this->response = [
            'data' => $this->content,
            'status' => $this->status,
        ];
    }

    public function test_respond_with_json_job()
    {
        $job = new RespondWithJsonJob($this->content, $this->status, $this->headers, $this->options);

        $jsonContent = json_encode($this->content);
        $this->responseFactory->shouldReceive('json')
            ->with($this->response, $this->status, $this->headers, $this->options)
            ->andReturn($jsonContent);

        $this->assertEquals($jsonContent, $job->handle($this->responseFactory));
    }
}
