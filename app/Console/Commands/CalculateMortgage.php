<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MortgageApiClient;

class CalculateMortgage extends Command
{
    protected $signature = 'mortgage:calculate-by {type} {value}';
    protected $description = 'Bereken de maximale hypotheek op basis van inkomen of woningwaarde';

    protected MortgageApiClient $mortgageApiClient;

    public function __construct(MortgageApiClient $mortgageApiClient)
    {
        parent::__construct();
        $this->mortgageApiClient = $mortgageApiClient;
    }

    public function handle(): int
    {

        $type = strtolower($this->argument('type'));
        $value = (int) $this->argument('value');

        if (!in_array($type, ['income', 'value'], true)) {
            $this->error(__('messages.invalid_type'));
            return 1;
        }

        if ($value <= 0) {
            $this->error(__('messages.invalid_value'));
            return 1;
        }

        if ($type === 'income') {
            $result = $this->mortgageApiClient->getMaximumMortgageByIncome($value);
            $this->info(__('messages.calculation_based_on_income') . round($result['data']['result'], 2));
        } elseif ($type === 'value') {
            $result = $this->mortgageApiClient->getMaximumMortgageByValue($value);
            $this->info(__('messages.calculation_based_on_property_value') . $result['data']['result']);
        }

        return 0;
    }
}
