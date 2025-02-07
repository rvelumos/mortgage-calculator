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
    public function expect_command_fails_when_two_arguments_are_passed()
    {
        $this->artisan('mortgage:calculate 100000 350000')
            ->expectsOutput(__('messages.fill_one_field'))
            ->assertExitCode(1);
    }

    #[Test]
    public function expect_command_fails_when_invalid_arguments_are_passed()
    {
        $this->artisan('mortgage:calculate ABC XXX')
            ->expectsOutput(__('messages.error_message'))
            ->assertExitCode(1);
    }

    #[Test]
    public function expect_printed_message_with_calculated_mortgage()
    {

        $this->artisan('mortgage:calculate 100000 0')
            ->expectsOutput(__('messages.calculation_based_on_income').'560213.43')
            ->assertExitCode(0);
    }
}
