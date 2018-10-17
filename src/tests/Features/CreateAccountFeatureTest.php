<?php
namespace App\Tests\Features;

use App\Data\Models\Domain;
use App\Data\Models\Key;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateAccountFeatureTest extends TestCase
{
    use DatabaseMigrations;

    private $data = [
        'login' => 'login',
        'password' => 'pass',
        'hashed_password' => null,
        'status' => 1,
        'relative_dir' => 'dir',
        'description' => 'desc',
    ];
    private $accountKey = 'account_key';
    private $domain;
    private $domainName = 'domain_name';

    public function setUp()
    {
        parent::setUp();

        $this->domain = new Domain([
            'name' => $this->domainName,
        ]);
        $this->domain->save();

        (new Key([
            'domain_id' => $this->domain->id,
            'token' => $this->accountKey,
        ]))->save();
    }

    public function test_create_account_feature()
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->accountKey,
        ];
        $response = $this->json('POST', '/api/v1/accounts', $this->data, $headers)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'domain_id',
                    'login',
                    'status',
                    'relative_dir',
                    'description',
                    'updated_at',
                    'created_at',
                    'domain' => ['id', 'name'],
                ]
            ]);
    }
}
