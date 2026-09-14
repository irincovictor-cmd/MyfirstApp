<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Students</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #1e293b;
            --line: #334155;
            --ink: #e2e8f0;
            --muted: #94a3b8;
            --accent: #38bdf8;
            --ok: #4ade80;
            --danger: #f87171;
            --ok-bg: rgba(74, 222, 128, 0.12);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            padding: 1.5rem;
        }
        header {
            max-width: 960px;
            margin: 0 auto 1.5rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        h1 { font-size: 1.4rem; }
        .sub { color: var(--muted); font-size: 0.9rem; margin-top: 0.25rem; }
        .links { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem; }
        .links a {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.9rem;
        }
        .links a:hover { text-decoration: underline; }
        .btn-logout {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--muted);
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            font-family: inherit;
        }
        .btn-logout:hover { color: var(--ink); border-color: var(--muted); }
        .flash {
            max-width: 960px;
            margin: 0 auto 1rem;
            background: var(--ok-bg);
            color: var(--ok);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .stats {
            max-width: 960px;
            margin: 0 auto 1.25rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .stat {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 0.85rem 1.1rem;
            min-width: 140px;
        }
        .stat strong { display: block; font-size: 1.4rem; color: var(--accent); }
        .stat span { font-size: 0.8rem; color: var(--muted); }
        .panel {
            max-width: 960px;
            margin: 0 auto;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
        }
        .panel h2 {
            font-size: 0.95rem;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--line);
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        table { width: 100%; border-collapse: collapse; font-size: 0.92rem; }
        th, td {
            text-align: left;
            padding: 0.7rem 1rem;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }
        th { color: var(--muted); font-weight: 600; font-size: 0.8rem; }
        tr:last-child td { border-bottom: none; }
        .muted { color: var(--muted); }
        .badge {
            display: inline-block;
            background: rgba(74, 222, 128, 0.15);
            color: var(--ok);
            padding: 0.15rem 0.45rem;
            border-radius: 4px;
            font-size: 0.75rem;
        }
        .btn-delete {
            background: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            font-family: inherit;
        }
        .btn-delete:hover {
            background: rgba(248, 113, 113, 0.15);
        }
        .empty { padding: 1.5rem 1rem; color: var(--muted); }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Site administration</h1>
            <p class="sub">MyfirstApp — students & details (protected)</p>
        </div>
        <div class="links">
            <a href="/student">Add student</a>
            <a href="/student-details">Add details</a>
            <a href="/home">Portfolio</a>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Log out</button>
            </form>
        </div>
    </header>

    @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <div class="stats">
        <div class="stat">
            <strong>{{ $students->count() }}</strong>
            <span>Students</span>
        </div>
        <div class="stat">
            <strong>{{ $detailsCount }}</strong>
            <span>Detail records</span>
        </div>
    </div>

    <div class="panel">
        <h2>Students</h2>
        @if ($students->isEmpty())
            <p class="empty">No students yet. <a href="/student" style="color: var(--accent);">Create one</a>.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Age</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->course }}</td>
                            <td>{{ $student->age }}</td>
                            <td>
                                @if ($student->detail)
                                    {{ $student->detail->address }}
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($student->detail)
                                    {{ $student->detail->contact }}
                                    <span class="badge">linked</span>
                                @else
                                    <span class="muted">no details</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                      onsubmit="return confirm('Delete {{ $student->name }}? Details will be removed too.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
