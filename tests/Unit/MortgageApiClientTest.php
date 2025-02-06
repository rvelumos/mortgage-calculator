<?php

namespace Tests\Unit;

use App\Services\MortgageApiClient;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MortgageApiClientTest extends TestCase
{
    protected mixed $baseUrl;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = config('mortgage.base_url');
        $this->mortgageClient = new MortgageApiClient();
    }

    #[Test]
    public function expect_response_with_results_maximum_mortgage_by_income(): void
    {
        Http::fake([
            "{$this->baseUrl}calculation/v1/mortgage/maximum-by-income*" => Http::response([
                'data' => [
                    'result' => 572850,
                    'calculationValues' => [
                        'totalReferenceIncome' => 100000,
                        'firstGrossPayment' => 1846.46,
                    ],
                ],
            ]),
        ]);

        $result = $this->mortgageClient->getMaximumMortgageByIncome(100000);

        $this->assertEquals(572850, $result['data']['result']);
        $this->assertEquals(1846.46, $result['data']['calculationValues']['firstGrossPayment']);
    }

    #[Test]
    public function expect_error_handling_when_url_is_missing_income_parameter(): void
    {
        Http::fake([
            "{$this->baseUrl}calculation/v1/mortgage/maximum-by-income*" => Http::response([
                'error' => [
                    'code' => 400,
                    'message' => 'Parameter person[0][income] is required.',
                ]
            ], 400),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Parameter person[0][income] is required.');

        $this->mortgageClient->getMaximumMortgageByIncome(null);
    }

    #[Test]
    public function expect_error_handling_when_response_has_invalid_value(): void
    {
        Http::fake([
            "{$this->baseUrl}calculation/v1/mortgage/maximum-by-value*" => Http::response([
                'error' => [
                    'code' => 400,
                    'message' => 'Invalid object value provided',
                ]
            ], 400),
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid object value provided');

        $this->mortgageClient->getMaximumMortgageByValue(-50000);
    }

    #[Test]
    public function expect_response_with_maximum_by_value(): void
    {
        Http::fake([
            "{$this->baseUrl}calculation/v1/mortgage/maximum-by-value*" => Http::response([
                'data' => [
                    'result' => 350000,
                    'calculationValues' => [
                        'firstGrossPayment' => 522.67,
                        'interestRate' => 3.84,
                    ],
                ],
            ]),
        ]);

        $result = $this->mortgageClient->getMaximumMortgageByValue(350000);

        $this->assertEquals(350000, $result['data']['result']);
        $this->assertEquals(522.67, $result['data']['calculationValues']['firstGrossPayment']);
    }

    #[Test]
    public function expect_large_number_in_response_maximum_income_to_be_handled()
    {
        Http::fake([
            "{$this->baseUrl}calculation/v1/mortgage/maximum-by-income*" => Http::response([
                'data' => [
                    'result' => 999999999.99,
                    'calculationValues' => [
                        'totalReferenceIncome' => 999999999,
                        'firstGrossPayment' => 999999.99,
                    ],
                ],
            ]),
        ]);

        $result = $this->mortgageClient->getMaximumMortgageByIncome(999999999);

        $this->assertEquals(999999999.99, $result['data']['result']);
    }
}

