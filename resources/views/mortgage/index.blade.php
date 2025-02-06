<form action="{{ route('mortgage.calculate') }}" method="POST">
    @csrf
    <label for="income">{{ __('messages.enter_income') }}</label>
    <input type="number" id="income" name="income" required>

    <label for="object_value">{{ __('messages.enter_object_value') }}</label>
    <input type="number" id="object_value" name="object_value" required>

    <button type="submit">{{ __('messages.calculate') }}</button>
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
