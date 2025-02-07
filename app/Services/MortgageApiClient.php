<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class MortgageApiClient
{
    protected mixed $baseUrl;
    protected mixed $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('mortgage.base_url');
        $this->apiKey = config('mortgage.api_key');
    }

    public function getMaximumMortgageByIncome($income)
    {
        $response = Http::get($this->baseUrl . 'calculation/v1/mortgage/maximum-by-income', [
            'percentage' => 1.501,
            'person[0][income]' => $income,
            'api_key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            throw new Exception($response->json('error.message'));
        }

        return $response->json();
    }

    public function getMaximumMortgageByValue($value)
    {

        $response = Http::get($this->baseUrl . 'calculation/v1/mortgage/maximum-by-value', [
            'objectvalue' => $value,
            'api_key' => $this->apiKey,
        ]);

        if ($response->failed()) {
            throw new Exception($response->json('error.message'));
        }

        return $response->json();
    }
}
