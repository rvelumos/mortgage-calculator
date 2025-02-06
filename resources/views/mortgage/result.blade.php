<div>
    <h1>{{ __('messages.max_mortgage_income') }}</h1>
    <p>{{ $maxByIncome }}</p>

    <h1>{{ __('messages.max_mortgage_value') }}</h1>
    <p>{{ $maxByValue }}</p>

    <h2>{{ __('messages.calculation_details') }}</h2>
    <ul>
        <li>{{ __('messages.gross_payment') }} {{ $calculationValues['firstGrossPayment'] }}</li>
        <li>{{ __('messages.interest_rate') }} {{ $calculationValues['interestRate'] ?? '1.501%' }}</li>
    </ul>
</div>
