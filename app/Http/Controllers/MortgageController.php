<?php

namespace App\Http\Controllers;

use App\Services\MortgageApiClient;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MortgageController extends Controller
{
    protected MortgageApiClient $client;

    public function __construct(MortgageApiClient $client)
    {
        $this->client = $client;
    }

    public function index(): View|Factory|Application
    {
        return view('mortgage.index');
    }

    public function calculate(Request $request): Factory|View|Application|RedirectResponse
    {
        $data = $request->only(['income', 'object_value']);

        $validator = Validator::make($data, [
            'income' => 'nullable|numeric|required_without:object_value',
            'object_value' => 'nullable|numeric|required_without:income',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            if (!empty($data['income'])) {
                $result = $this->client->getMaximumMortgageByIncome($data['income']);

                return view('mortgage.result', ['result' => $result, 'type' => 'income']);
            } else {
                $result = $this->client->getMaximumMortgageByValue($data['object_value']);

                return view('mortgage.result', ['result' => $result, 'type' => 'value']);
            }
        } catch (RequestException $e) {
            return back()->withErrors(['api_error' => __('messages.api_error')])->withInput();
        }
    }
}
