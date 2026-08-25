<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link rel="stylesheet" href="{{ asset('css/operator.css') }}">
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
        }
        h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        .nav-links {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .nav-links a {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            background: #e9ecef;
            color: #333;
            font-weight: 500;
            transition: all 0.2s;
        }
        .nav-links a:hover {
            background: #dee2e6;
        }
        .nav-links a.active {
            background: #0d6efd;
            color: white;
        }
        .field {
            margin-bottom: 1rem;
        }
        .field label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: 500;
            color: #555;
        }
        .field input {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        button:hover {
            background: #0b5ed7;
        }
        .error {
            background: #f8d7da;
            color: #842029;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
        .result {
            margin-top: 1.25rem;
            padding: 1rem;
            background: #d1e7dd;
            color: #0f5132;
            border-radius: 8px;
            text-align: center;
            font-size: 1.2rem;
        }
        .hint {
            text-align: center;
            color: #6c757d;
            margin-top: 1rem;
        }
    </style>
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
