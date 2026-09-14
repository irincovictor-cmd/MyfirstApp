<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 420px; margin: 2rem auto; padding: 0 1rem; }
        label { display: inline-block; min-width: 5rem; }
        input { margin-bottom: 0.75rem; padding: 0.35rem 0.5rem; }
        button { margin-top: 0.5rem; padding: 0.45rem 1rem; cursor: pointer; }
        .success { color: green; margin-bottom: 1rem; }
        .errors { color: #b91c1c; margin-bottom: 1rem; }
        a { color: #1d4ed8; }
    </style>
</head>
<body>
    <h1>Student Information</h1>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/student" method="POST">
        @csrf

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label for="course">Course:</label>
            <input type="text" id="course" name="course" value="{{ old('course') }}">
        </div>

        <div>
            <label for="age">Age:</label>
            <input type="text" id="age" name="age" value="{{ old('age') }}">
        </div>

        <button type="submit">Submit</button>
    </form>

    <p style="margin-top: 1.5rem;">
        <a href="/student-details">Add student details (address / contact)</a>
    </p>
</body>
</html>
