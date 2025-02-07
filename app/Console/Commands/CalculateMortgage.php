<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MortgageApiClient;

class CalculateMortgage extends Command
{
    protected $signature = 'mortgage:calculate {income} {propertyValue}';
    protected $description = 'Bereken de maximale hypotheek op basis van inkomen of woningwaarde';

    protected MortgageApiClient $mortgageApiClient;

    public function __construct(MortgageApiClient $mortgageApiClient)
    {
        parent::__construct();
        $this->mortgageApiClient = $mortgageApiClient;
    }

    public function handle(): int
    {

        $income = (int) $this->argument('income');
        $propertyValue = (int) $this->argument('propertyValue');

        if ($income > 0 && $propertyValue > 0) {
            $this->error(__('messages.fill_one_field'));

            return 1;
        } elseif ($income > 0) {
            $result = $this->mortgageApiClient->getMaximumMortgageByIncome($income);

            $this->info(__('messages.calculation_based_on_income') . round($result['data']['result'],2));
            return 0;
        } elseif ($propertyValue > 0) {
            $result = $this->mortgageApiClient->getMaximumMortgageByValue($propertyValue);

            $this->info(__('messages.calculation_based_on_property_value') . $result['data']['result']);
            return 0;
        }

        $this->error(__('messages.error_message'));
        return 1;
    }
}
