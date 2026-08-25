<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
</head>
<body>



    <div class="card">
        <h2>Select Operation</h2>

        <div class="nav-links">
            <a href="{{ route('operator.show', 'add') }}" class="{{ ($selectedOperator ?? '') == 'add' ? 'active' : '' }}">+ add</a>
            <a href="{{ route('operator.show', 'subtract') }}" class="{{ ($selectedOperator ?? '') == 'subtract' ? 'active' : '' }}">- subtract</a>
            <a href="{{ route('operator.show', 'multiply') }}" class="{{ ($selectedOperator ?? '') == 'multiply' ? 'active' : '' }}">* multiply</a>
            <a href="{{ route('operator.show', 'divide') }}" class="{{ ($selectedOperator ?? '') == 'divide' ? 'active' : '' }}">/ divide</a>
        </div>

    </div>

    
    @if (isset($selectedOperator))
        @if ($errors->any())
            <div class="error">
                @foreach ($error->all() as $error )
                    <p>{{ $error }}</p>    
                @endforeach
            </div>    
        
        @endif
    @endif

                <form action="{{ route ('operator.calculate', $selectedOperator ?? '') }}" method="POST">
                    @csrf
                    <div class="field">
                        <label>First number:</label>
                        <input type="number" step="any" name="num1" value="{{ old ('num1', $num1 ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label>Second number:</label>
                        <input type="number" step="any" name="num2" value="{{ old ('num2', $num2 ?? '') }}" required>
                    </div>

                    <button type="submit">Calculate ( {{ strtoupper($selectedOperator) }})</button>

                </form>


                @if(isset($result))
                <div class="result">
                    <strong>Result:</strong> {{ $result }}
                </div>
                @endif
            </div>
          





        <!-- <section class="addition" id="addition">
    <div class="container">
        <form action="/operator" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="course">Course:</label>
                <input type="text" id="course" name="course" required>
            </div>

            <button type="submit">Submit</button>
        </form>

        @if(isset($name))
        <div class="result">
            <p><strong>Name:</strong> {{ $name }}</p>
            <p><strong>Course:</strong> {{ $course }}</p>
        </div>
        @endif -->


</body>

</html>