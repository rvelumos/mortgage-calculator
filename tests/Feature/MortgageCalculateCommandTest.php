<?php

namespace Tests\Feature;

use App\Services\MortgageApiClient;
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
    public function expect_command_fails_when_invalid_arguments_are_passed()
    {
        $this->artisan('mortgage:calculate-by value XXX')
            ->expectsOutput(__('messages.invalid_value'))
            ->assertExitCode(1);

        $this->artisan('mortgage:calculate-by test 1000')
            ->expectsOutput(__('messages.invalid_type'))
            ->assertExitCode(1);
    }

    #[Test]
    public function expect_printed_message_with_calculated_mortgage()
    {

        $this->artisan('mortgage:calculate-by income 10000')
            ->expectsOutput(__('messages.calculation_based_on_income') . '38628.51')
            ->assertExitCode(0);
    }
}
