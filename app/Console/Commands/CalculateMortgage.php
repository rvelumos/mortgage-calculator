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

        $income = $this->argument('income');
        $propertyValue = $this->argument('propertyValue');

        if (empty($income) || empty($propertyValue)) {
            $this->error('The income or property value parameters are required.');
            return 1;
        }

        if ($income > 0) {
            $result = $this->mortgageApiClient->getMaximumMortgageByIncome($income);
            $this->info("Maximale hypotheek op basis van inkomen: " . $result['max_mortgage']);
            return 0;
        } elseif ($propertyValue > 0) {
            $result = $this->mortgageApiClient->getMaximumMortgageByValue($propertyValue);
            $this->info("Maximale hypotheek op basis van woningwaarde: " . $result['max_mortgage']);
            return 0;
        } else {
            $this->error('Geef zowel inkomen als woningwaarde op om een berekening uit te voeren.');
            return 1;
        }
    }
}
