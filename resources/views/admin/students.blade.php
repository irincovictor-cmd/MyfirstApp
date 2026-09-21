<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Students</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #0f172a; color: #e2e8f0; padding: 1.5rem; }
        a { color: #38bdf8; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: .7rem; border-bottom: 1px solid #334155; }
    </style>
</head>
<body>
    <h1>Students admin</h1>
    <p><a href="/student">Add student</a> · <a href="/blood/admin">Blood admin</a></p>
    @if(session('success'))<p style="color:#4ade80;">{{ session('success') }}</p>@endif
    <p>Students: {{ $students->count() }} · Details: {{ $detailsCount }}</p>
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Age</th><th></th></tr></thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->age }}</td>
                <td>
                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete?');">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
