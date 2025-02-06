<?php

namespace Tests\Feature;

use App\Services\MortgageApiClient;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MortgageCalculateCommandTest extends TestCase
{

    protected mixed $baseUrl;
    protected mixed $apiKey;
    protected function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = config('mortgage.base_url');
        $this->mortgageClient = new MortgageApiClient();
    }

    #[Test]
    public function test_command_returns_correct_mortgage_data()
    {
        Http::fake([
            "{$this->baseUrl}/calculation/v1/mortgage/maximum-by-income*" => Http::response([
                'data' => ['result' => 572850.29],
            ]),
            "{$this->baseUrl}/calculation/v1/mortgage/maximum-by-value*" => Http::response([
                'data' => ['result' => 350000],
            ]),
        ]);

        $this->artisan('mortgage:calculate 100000 350000')
            ->expectsOutput('Max mortgage by income: 572850.29')
            ->expectsOutput('Max mortgage by value: 350000')
            ->assertExitCode(0);
    }

    #[Test]
    public function test_command_handles_invalid_api_key()
    {
        Http::fake([
            "{$this->baseUrl}/calculation/v1/mortgage/maximum-by-income*" => Http::response([
                'error' => ['code' => 403, 'message' => 'Invalid apiKey provided']
            ], 403),
        ]);

        $this->artisan('mortgage:calculate 100000 350000')
            ->assertExitCode(1);
    }
}
