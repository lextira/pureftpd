<?php
namespace App\Tests\Features;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use App\Data\Models\Key;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ListAccountsFeatureTest extends TestCase
{
    use DatabaseMigrations;

    private $accountKey = 'account_key';
    private $domain;
    private $restrictedDomain;
    private $headers;

    public function setUp()
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

        (new Account([
            'domain_id' => $this->domain->id,
            'relative_dir' => 'dir',
            'login' => 'login',
            'password' => 'password',
            'status' => 1,
        ]))->save();

        (new Account([
            'domain_id' => $this->restrictedDomain->id,
            'relative_dir' => 'dir2',
            'login' => 'login2',
            'password' => 'password2',
            'status' => 2,
        ]))->save();

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accountKey,
        ];
    }

    public function test_list_accounts_feature()
    {
        $response = $this->json('GET', '/api/v1/accounts', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        '*' => [
                            'id',
                            'domain_id',
                            'login',
                            'status',
                            'relative_dir',
                            'description',
                            'updated_at',
                            'created_at',
                        ]
                    ]
                ]
            ]);
    }
}
