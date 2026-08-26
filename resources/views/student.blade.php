<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f4f6f8;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
            text-align: center;
        }
        .form-group { margin-bottom: 1rem; }
        label {
            display: block;
            margin-bottom: 0.35rem;
            font-size: 0.9rem;
            font-weight: 600;
        }
        input {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        input:focus {
            outline: none;
            border-color: #0d6efd;
        }
        button {
            width: 100%;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }
        button:hover { background: #0b5ed7; }
        .errors {
            background: #f8d7da;
            color: #842029;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .errors p { margin: 0.2rem 0; }
        .result {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #d1e7dd;
            border-radius: 6px;
            color: #0f5132;
        }
        .result p { margin: 0.3rem 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Form</h1>

        {{-- Show validation errors if any --}}
        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Simple form: posts to named route student.show --}}
        <form action="{{ route('student.show') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $name ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" id="course" name="course"
                       value="{{ old('course', $course ?? '') }}" required>
            </div>

            <div class="form-group">
                <label for="year">Year (optional)</label>
                <input type="text" id="year" name="year"
                       value="{{ old('year', $year ?? '') }}"
                       placeholder="e.g. 3rd year">
            </div>

            <button type="submit">Submit</button>
        </form>

        {{-- Show submitted data after successful POST --}}
        @if(isset($name))
            <div class="result">
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Course:</strong> {{ $course }}</p>
                @if(!empty($year))
                    <p><strong>Year:</strong> {{ $year }}</p>
                @endif
            </div>
        @endif
    </div>
</body>
</html>
