@extends('layouts.app')

@section('content')
    <h1>{{ __('messages.mortgage_calculator') }}</h1>
    <p>{{ __('messages.description') }}</p>
    <form action="{{ route('mortgage.calculate') }}" method="POST" onsubmit="return validateForm()">
        @csrf
        <label for="income">{{ __('messages.income_label') }}</label>
        <input type="number" id="income" name="income" value="{{ old('income') }}">

        <label for="object_value">{{ __('messages.value_label') }}</label>
        <input type="number" id="object_value" name="object_value" value="{{ old('object_value') }}">

        <button type="submit">{{ __('messages.calculate_button') }}</button>
    </form>

    @if ($errors->any())
        <div>
            <strong>{{ __('messages.error') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
