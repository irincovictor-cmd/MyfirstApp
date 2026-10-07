@extends('layouts.blood')
@section('title', 'Manage users')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">👤 Accounts</h1>
        <p class="section-sub">Change password, role, or delete</p>
    </div>
    <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
        <a class="btn btn-ghost" href="{{ route('blood.admin.dashboard') }}">← Dashboard</a>
        <a class="btn btn-primary" href="{{ route('blood.admin.create') }}">+ Admin</a>
    </div>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>New password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $account)
                <tr>
                    <td>
                        <strong>{{ $account->name }}</strong>
                        @if($account->id === auth()->id())
                            <span class="badge">you</span>
                        @endif
                    </td>
                    <td>{{ $account->email }}</td>
                    <td>
                        <form method="POST" action="{{ route('blood.admin.user.role', $account) }}" style="display:inline-flex;gap:0.25rem;align-items:center;">
                            @csrf
                            <select name="role" style="width:auto;padding:0.25rem 0.4rem;font-size:0.8rem;" @disabled($account->id === auth()->id())>
                                <option value="user" @selected($account->role === 'user')>user</option>
                                <option value="admin" @selected($account->role === 'admin')>admin</option>
                            </select>
                            @if($account->id !== auth()->id())
                                <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;">Set</button>
                            @endif
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('blood.admin.user.password', $account) }}" style="display:flex;flex-wrap:wrap;gap:0.25rem;align-items:center;">
                            @csrf
                            <input type="password" name="password" placeholder="New pass" required minlength="4" style="width:7rem;padding:0.3rem 0.4rem;font-size:0.8rem;">
                            <input type="password" name="password_confirmation" placeholder="Confirm" required minlength="4" style="width:7rem;padding:0.3rem 0.4rem;font-size:0.8rem;">
                            <button type="submit" class="btn btn-primary" style="padding:0.25rem 0.45rem;font-size:0.72rem;">Update</button>
                        </form>
                    </td>
                    <td>
                        @if($account->id === auth()->id())
                            <span style="color:var(--muted);font-size:0.8rem;">—</span>
                        @else
                            <form method="POST" action="{{ route('blood.admin.user.destroy', $account) }}" onsubmit="return confirm('Delete {{ $account->email }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;color:#9f1239;">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:var(--muted);">No accounts</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
