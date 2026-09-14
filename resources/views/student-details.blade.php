<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <style>
        :root {
            --bg: #f0f4f8;
            --card: #ffffff;
            --ink: #1e293b;
            --muted: #64748b;
            --line: #e2e8f0;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --ok: #15803d;
            --ok-bg: #dcfce7;
            --err: #b91c1c;
            --err-bg: #fee2e2;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .card {
            background: var(--card);
            width: 100%;
            max-width: 440px;
            border-radius: 12px;
            border: 1px solid var(--line);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 1.75rem 1.5rem 1.5rem;
        }
        h1 { font-size: 1.35rem; font-weight: 700; margin-bottom: 0.25rem; }
        .sub { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.25rem; }
        .success {
            background: var(--ok-bg); color: var(--ok);
            padding: 0.65rem 0.85rem; border-radius: 8px;
            font-size: 0.9rem; margin-bottom: 1rem;
        }
        .errors {
            background: var(--err-bg); color: var(--err);
            padding: 0.65rem 0.85rem; border-radius: 8px;
            font-size: 0.9rem; margin-bottom: 1rem;
        }
        .errors ul { margin-left: 1.1rem; }
        .field { margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem; }
        input, select {
            width: 100%; padding: 0.6rem 0.75rem;
            border: 1px solid var(--line); border-radius: 8px;
            font-size: 1rem; font-family: inherit; background: #fff;
        }
        input:focus, select:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        button {
            width: 100%; margin-top: 0.35rem; padding: 0.7rem 1rem;
            background: var(--accent); color: #fff; border: none;
            border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer;
        }
        button:hover { background: var(--accent-hover); }
        .footer-link { margin-top: 1.25rem; text-align: center; font-size: 0.9rem; }
        .footer-link a { color: var(--accent); text-decoration: none; font-weight: 500; }
        .footer-link a:hover { text-decoration: underline; }
        .empty-note {
            background: #fff7ed; color: #9a3412;
            padding: 0.65rem 0.85rem; border-radius: 8px;
            font-size: 0.9rem; margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Student Details</h1>
        <p class="sub">Link address and contact to a student already in the database.</p>

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

        @if ($students->isEmpty())
            <div class="empty-note">
                No students yet. <a href="/student">Add a student first</a>, then come back here.
            </div>
        @else
            <form action="/student-details" method="POST">
                @csrf
                <div class="field">
                    <label for="student_id">Student</label>
                    <select name="student_id" id="student_id" required>
                        <option value="">— Select student —</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->name }} ({{ $student->course }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Street, city…" required>
                </div>
                <div class="field">
                    <label for="contact">Contact</label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact') }}" placeholder="Phone or mobile" required>
                </div>
                <button type="submit">Save details</button>
            </form>
        @endif

        <p class="footer-link">
            <a href="/student">← Back to student form</a>
        </p>
    </div>
</body>
</html>
