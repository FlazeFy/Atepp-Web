<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Tests\TestCase;

// Helpers
use App\Helpers\Audit;
use App\Helpers\Generator;

class HelpersGeneratorTest extends TestCase
{ 
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();
        $this->httpClient = new Client([
            'base_uri' => 'http://127.0.0.1:8000/',
            'http_errors' => false
        ]);
    }

    public function test_generator_get_uuid(): void
    {   
        $check_length = 36;

        // Exec
        $check = Generator::getUUID();

        // Test Parameter
        $this->assertIsString($check);
        $this->assertEquals($check_length, strlen($check));

        Audit::auditRecordText("Test - Generator Helper", "Generator-getUUID", "Result : ".$check);
        Audit::auditRecordSheet("Test - Generator Helper", "Generator-getUUID",'',$check);
    }
}
