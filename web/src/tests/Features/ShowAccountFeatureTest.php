<?php
namespace App\Tests\Features;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use App\Data\Models\Key;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Features\ShowAccountFeature;

class ShowAccountFeatureTest extends TestCase
{
    use DatabaseMigrations;

    private $accountKey = 'account_key';
    private $domain;
    private $restrictedDomain;
    private $account;
    private $restrictedAccount;
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

        $this->account = new Account([
            'domain_id' => $this->domain->id,
            'relative_dir' => 'dir',
            'login' => 'login',
            'password' => 'password',
            'status' => 1,
        ]);
        $this->account->save();

        $this->restrictedAccount = new Account([
            'domain_id' => $this->restrictedDomain->id,
            'relative_dir' => 'dir2',
            'login' => 'login2',
            'password' => 'password2',
            'status' => 2,
        ]);
        $this->restrictedAccount->save();

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->accountKey,
        ];
    }

    public function test_list_accounts_feature()
    {
        $url = '/api/v1/accounts/' . $this->account->id;

        $response = $this->json('GET', $url, [], $this->headers)
            ->assertStatus(200)
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
                ]
            ]);
    }

    public function test_list_accounts_feature_not_found()
    {
        $url = '/api/v1/accounts/' . $this->restrictedAccount->id;

        $response = $this->json('GET', $url, [], $this->headers)
            ->assertStatus(404)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
