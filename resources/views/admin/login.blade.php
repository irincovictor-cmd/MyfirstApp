<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login</title>
    <style>
        :root {
            --bg: #0f172a;
            --panel: #1e293b;
            --line: #334155;
            --ink: #e2e8f0;
            --muted: #94a3b8;
            --accent: #38bdf8;
            --err: #f87171;
            --err-bg: rgba(248, 113, 113, 0.12);
            --ok: #4ade80;
            --ok-bg: rgba(74, 222, 128, 0.12);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .card {
            width: 100%;
            max-width: 360px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 1.75rem 1.5rem;
        }
        h1 { font-size: 1.25rem; margin-bottom: 0.35rem; }
        .sub { color: var(--muted); font-size: 0.88rem; margin-bottom: 1.25rem; }
        label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.35rem; }
        input {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--bg);
            color: var(--ink);
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        input:focus { outline: 2px solid var(--accent); border-color: transparent; }
        button {
            width: 100%;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            background: var(--accent);
            color: #0f172a;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
        }
        .errors {
            background: var(--err-bg);
            color: var(--err);
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 1rem;
        }
        .flash {
            background: var(--ok-bg);
            color: var(--ok);
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 1rem;
        }
        .back {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--muted);
            font-size: 0.85rem;
            text-decoration: none;
        }
        .back:hover { color: var(--accent); }
    </style>
</head>
<body>
    <div class="card">
        <h1>Admin login</h1>
        <p class="sub">Password required to view or delete student records.</p>

        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="errors">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required autofocus autocomplete="current-password">
            <button type="submit">Log in</button>
        </form>

        <a class="back" href="/home">← Back to site</a>
    </div>
</body>
</html>
