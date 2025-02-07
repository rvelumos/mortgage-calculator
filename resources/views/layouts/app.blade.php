<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            const income = document.getElementById('income').value.trim();
            const objectValue = document.getElementById('object_value').value.trim();

            if (income === '' && objectValue === '') {
                alert("{{ __('messages.fill_one_field') }}");
                return false;
            }

            if (income !== '' && objectValue !== '') {
                alert("{{ __('messages.both_fields_filled') }}");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<div class="container mt-5">
    @yield('content')
</div>
</body>
</html>
