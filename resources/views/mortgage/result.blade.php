@extends('layouts.app')

@section('content')
    <h1>{{ __('messages.mortgage_result') }}</h1>

    @if ($type === 'income')
        <p>{{ __('messages.calculation_based_on_income') }}</p>
        <p>{{ __('messages.entered_income') }}: €{{ number_format($result['data']['calculationValues']['totalReferenceIncome'], 2) }}</p>
        <p>{{ __('messages.maximum_mortgage') }}: €{{ number_format($result['data']['result'], 2) }}</p>
        <p>{{ __('messages.first_gross_payment') }}: €{{ number_format($result['data']['calculationValues']['firstGrossPayment'], 2) }}</p>
    @elseif ($type === 'value')
        <p>{{ __('messages.calculation_based_on_property_value') }}</p>
        <p>{{ __('messages.entered_property_value') }}: €{{ number_format($result['data']['result'], 2) }}</p>
        <p>{{ __('messages.maximum_mortgage') }}: €{{ number_format($result['data']['result'], 2) }}</p>
        <p>{{ __('messages.first_gross_payment') }}: €{{ number_format($result['data']['calculationValues']['firstGrossPayment'], 2) }}</p>
        <p>{{ __('messages.interest_rate') }}: {{ $result['data']['calculationValues']['interestRate'] }}%</p>
    @endif

    <a href="{{ route('mortgage.index') }}">{{ __('messages.back_to_form') }}</a>
@endsection
