<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/operator.css') }}">
</head>
<body>

    <div class="card">
        <h2>Simple Calculator</h2>

        <div class="nav-links">
            <a href="{{ route('operator.show', 'add') }}" class="{{ ($selectedOperator ?? '') == 'add' ? 'active' : '' }}">+ Add</a>
            <a href="{{ route('operator.show', 'subtract') }}" class="{{ ($selectedOperator ?? '') == 'subtract' ? 'active' : '' }}">− Subtract</a>
            <a href="{{ route('operator.show', 'multiply') }}" class="{{ ($selectedOperator ?? '') == 'multiply' ? 'active' : '' }}">× Multiply</a>
            <a href="{{ route('operator.show', 'divide') }}" class="{{ ($selectedOperator ?? '') == 'divide' ? 'active' : '' }}">÷ Divide</a>
        </div>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p style="margin:0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (isset($selectedOperator) && $selectedOperator)
            <form action="{{ route('operator.calculate', $selectedOperator) }}" method="POST">
                @csrf
                <div class="field">
                    <label>First number:</label>
                    <input type="number" step="any" name="num1" value="{{ old('num1', $num1 ?? '') }}" required>
                </div>

                <div class="field">
                    <label>Second number:</label>
                    <input type="number" step="any" name="num2" value="{{ old('num2', $num2 ?? '') }}" required>
                </div>

                <button type="submit">Calculate ({{ strtoupper($selectedOperator) }})</button>
            </form>

            @if (isset($result))
                <div class="result">
                    <strong>Result:</strong> {{ $result }}
                </div>
            @endif
        @else
            <p class="hint">Select an operation above to start calculating.</p>
        @endif
    </div>

</body>
</html>
