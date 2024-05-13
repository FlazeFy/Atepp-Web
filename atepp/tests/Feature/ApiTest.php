<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use GuzzleHttp\Client;
use Tests\TestCase;
use App\Helpers\Audit;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new Client([
            'base_uri' => 'http://127.0.0.1:8000/',
            'http_errors' => false
        ]);
    }

    // TC-001
    public function test_post_login()
    {
        // Exec
        $param['username'] = 'flazefy';
        $param['password'] = 'nopass123';

        $response = $this->httpClient->post("/api/v1/login", [
            'json' => [
                'username' => $param['username'],
                'password' => $param['password'],
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        // Test Parameter
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('role', $data);

        Audit::auditRecordText("Test - Post Login", "TC-001", "Token : ".$data['token']);
        Audit::auditRecordSheet("Test - Post Login", "TC-001", json_encode($param), $data['token']);
        return $data['token'];
    }

    // TC-002
    public function test_get_sign_out(): void
    {
        // Exec
        $token = $this->test_post_login();
        $response = $this->httpClient->get("/api/v1/logout", [
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        // Test Parameter
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('message', $data);

        Audit::auditRecordText("Test - Sign Out", "TC-002", "Result : ".json_encode($data));
        Audit::auditRecordSheet("Test - Sign Out", "TC-002", 'TC-001 test_post_login', json_encode($data));
    }

    // Stats

    // TC-003
    public function test_get_stats_general_response_time(): void
    {
        $token = $this->test_post_login();

        $response = $this->httpClient->get("/api/v1/stats/response/performance", [
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('message', $data);

        Audit::auditRecordText("Test - Get response time taken", "TC-003", "Result : ".json_encode($data));
        Audit::auditRecordSheet("Test - Get response time taken", "TC-003", '-', json_encode($data));
    }

    // TC-004
    public function test_get_stats_general_status_code(): void
    {
        $token = $this->test_post_login();

        $response = $this->httpClient->get("/api/v1/stats/response/status_code", [
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('message', $data);

        Audit::auditRecordText("Test - Get stats response status code", "TC-004", "Result : ".json_encode($data));
        Audit::auditRecordSheet("Test - Get stats response status code", "TC-004", '-', json_encode($data));
    }

    // TC-005
    public function test_get_stats_general_time_history(): void
    {
        $token = $this->test_post_login();

        $response = $this->httpClient->get("/api/v1/stats/response/time_history", [
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('message', $data);

        Audit::auditRecordText("Test - Get response time history", "TC-005", "Result : ".json_encode($data));
        Audit::auditRecordSheet("Test - Get response time history", "TC-005", '-', json_encode($data));
    }

    // TC-006
    public function test_get_all_project(): void
    {
        $token = $this->test_post_login();

        $response = $this->httpClient->get("/api/v1/project", [
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('message', $data);

        Audit::auditRecordText("Test - Get all project", "TC-006", "Result : ".json_encode($data));
        Audit::auditRecordSheet("Test - Get all project", "TC-006", '-', json_encode($data));
    }
}
