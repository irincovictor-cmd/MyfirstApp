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
            align-items: flex-start;
            min-height: 100vh;
            background: #f4f6f8;
            color: #333;
            padding: 2rem 1rem;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 480px;
        }
        h1 {
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
            text-align: center;
        }
        h2 {
            font-size: 1.1rem;
            margin: 1.5rem 0 0.75rem;
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
        .students-list {
            margin-top: 0.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }
        .students-list table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        .students-list th,
        .students-list td {
            padding: 0.5rem 0.75rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .students-list th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .students-list tr:last-child td { border-bottom: none; }
        .empty { color: #666; font-size: 0.9rem; }
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

        {{-- Form posts to named route student.show; fields match students table --}}
        <form action="{{ route('student.show') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="course">Course</label>
                <input type="text" id="course" name="course"
                       value="{{ old('course') }}" required>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="1" max="120"
                       value="{{ old('age') }}" required>
            </div>

            <button type="submit">Save Student</button>
        </form>

        {{-- Success message after saving to DB --}}
        @if(!empty($success))
            <div class="result">
                <p><strong>Saved successfully!</strong></p>
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Course:</strong> {{ $course }}</p>
                <p><strong>Age:</strong> {{ $age }}</p>
            </div>
        @endif

        {{-- List of all students from the database --}}
        <h2>Saved Students</h2>
        @if(isset($students) && $students->count() > 0)
            <div class="students-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->course }}</td>
                                <td>{{ $s->age }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="empty">No students saved yet.</p>
        @endif
    </div>
</body>
</html>
