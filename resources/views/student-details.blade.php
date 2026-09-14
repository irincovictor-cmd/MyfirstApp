<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 480px; margin: 2rem auto; padding: 0 1rem; }
        label { display: inline-block; min-width: 7rem; }
        input, select { margin-bottom: 0.75rem; padding: 0.35rem 0.5rem; min-width: 12rem; }
        button { margin-top: 0.5rem; padding: 0.45rem 1rem; cursor: pointer; }
        .success { color: green; margin-bottom: 1rem; }
        .errors { color: #b91c1c; margin-bottom: 1rem; }
        a { color: #1d4ed8; }
    </style>
</head>
<body>
    <h1>Student Details</h1>

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

    <form action="/student-details" method="POST">
        @csrf

        <div>
            <label for="student_id">Student Name:</label>
            <select name="student_id" id="student_id" required>
                <option value="">-- Select student --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                        {{ $student->name }} ({{ $student->course }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}">
        </div>

        <div>
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" value="{{ old('contact') }}">
        </div>

        <button type="submit">Submit</button>
    </form>

    <p style="margin-top: 1.5rem;">
        <a href="/student">Back to add student</a>
    </p>
</body>
</html>
