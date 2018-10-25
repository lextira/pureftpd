<?php
namespace App\Tests\Features;

use App\Data\Models\Account;
use App\Data\Models\Domain;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckHealthFeatureTest extends TestCase
{
    use DatabaseMigrations;

    private $domain;
    private $account;
    private $realAppURL;

    public function setUp()
    {
        parent::setUp();

        $this->realAppURL = config('app.url');
        $this->domain = new Domain([
            'name' => 'domain_name',
        ]);
        $this->domain->save();

        $this->account = new Account([
            'domain_id' => $this->domain->id,
            'relative_dir' => 'dir',
            'login' => 'login',
            'password' => 'password',
            'status' => 1,
        ]);
        $this->account->save();
    }

    public function test_check_health_feature()
    {
        $url = $this->realAppURL . '/api/v1/health/check';
        config(['app.url' => 'google.com']);

        $response = $this->json('GET', $url)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'db_status',
                    'ftp_status',
                    'ssl_status',
                ]
            ]);

        config(['app.url' => $this->realAppURL]);
    }

    public function test_check_health_feature_ssl_fail()
    {
        $url = $this->realAppURL . '/api/v1/health/check';
        config(['app.url' => 'not_real_domain.test']);

        $response = $this->json('GET', $url)
            ->assertStatus(500)
            ->assertJsonStructure([
                'data' => [
                    'db_status',
                    'ftp_status',
                    'ssl_status',
                ]
            ]);

        $this->assertNotEquals('OK', $response->getData()->data->ssl_status);
        config(['app.url' => $this->realAppURL]);
    }

    public function test_check_health_feature_db_fail()
    {
        $url = $this->realAppURL . '/api/v1/health/check';
        config(['app.url' => 'google.com']);

        $this->account->delete();

        $response = $this->json('GET', $url)
            ->assertStatus(500)
            ->assertJsonStructure([
                'data' => [
                    'db_status',
                    'ftp_status',
                    'ssl_status',
                ]
            ]);
        $this->assertNotEquals('OK', $response->getData()->data->db_status);

        config(['app.url' => $this->realAppURL]);

        $this->account = new Account([
            'domain_id' => $this->domain->id,
            'relative_dir' => 'dir',
            'login' => 'login',
            'password' => 'password',
            'status' => 1,
        ]);
        $this->account->save();
    }

    public function test_check_health_feature_ftp_fail()
    {
        $url = $this->realAppURL . '/api/v1/health/check';
        $ftpURL = config('ftp.url');
        config(['ftp.url' => 'not_real_domain.test']);

        $response = $this->json('GET', $url)
            ->assertStatus(500)
            ->assertJsonStructure([
                'data' => [
                    'db_status',
                    'ftp_status',
                    'ssl_status',
                ]
            ]);

        $this->assertNotEquals('OK', $response->getData()->data->ftp_status);

        config(['ftp.url' => $ftpURL]);
    }
}
