<?php
namespace App\Domains\Http\Tests\Jobs;

use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use Illuminate\Routing\ResponseFactory;
use Tests\TestCase;

class RespondWithJsonErrorJobTest extends TestCase
{
    private $message = 'Test occurred';
    private $code = 500;
    private $status = 600;
    private $headers = ['Content-Type' => 'application/json'];
    private $options = 1;
    private $responseFactory;
    private $content;

    public function setUp(): void
    {
        parent::setUp();

        $this->responseFactory = \Mockery::mock(ResponseFactory::class);
        $this->content = [
            'status' => $this->status,
            'error' => [
                'code' => $this->code,
                'message' => $this->message,
            ],
        ];
    }

    public function test_respond_with_json_error_job()
    {
        $job = new RespondWithJsonErrorJob($this->message, $this->code, $this->status, $this->headers, $this->options);

        $jsonContent = json_encode($this->content);
        $this->responseFactory->shouldReceive('json')
            ->with($this->content, $this->status, $this->headers, $this->options)
            ->andReturn($jsonContent);

        $this->assertEquals($jsonContent, $job->handle($this->responseFactory));
    }
}
