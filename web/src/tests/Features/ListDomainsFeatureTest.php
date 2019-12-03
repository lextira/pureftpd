<?php
namespace App\Tests\Features;

use App\Data\Models\Domain;
use App\Data\Models\Key;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ListDomainsFeatureTest extends TestCase
{
    use DatabaseMigrations;

    private $accountKey = 'account_key';
    private $domain;
    private $restrictedDomain;
    private $headers;

    public function setUp(): void
    {
        parent::setUp();

        $this->domain = new Domain([
            'name' => 'domain_name',
        ]);
        $this->domain->save();

        $this->restrictedDomain = new Domain([
            'name' => 'restricted_domain',
        ]);
        $this->restrictedDomain->save();

        (new Key([
            'domain_id' => $this->domain->id,
            'token' => $this->accountKey,
        ]))->save();

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accountKey,
        ];
    }

    public function test_list_domains_feature()
    {
        $response = $this->json('GET', '/api/v1/domains', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'updated_at',
                            'created_at',
                        ]
                    ]
                ]
            ]);
    }
}
