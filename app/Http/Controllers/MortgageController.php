<?php

namespace App\Http\Controllers;

use App\Services\MortgageApiClient;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;

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

    public function calculate(Request $request)
    {
        $request->validate([
            'income' => 'required|numeric|min:0',
            'object_value' => 'required|numeric|min:0',
        ]);

        try {
            $maxByIncome = $this->client->getMaximumMortgageByIncome($request->input('income'));
            $maxByValue = $this->client->getMaximumMortgageByValue($request->input('object_value'));

            return view('result', [
                'maxByIncome' => $maxByIncome['data']['result'],
                'maxByValue' => $maxByValue['data']['result'],
                'calculationValues' => $maxByValue['data']['calculationValues'],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
