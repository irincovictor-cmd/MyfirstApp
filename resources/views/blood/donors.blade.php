@extends('blood.layout')

@section('title', 'Donors')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 class="section-title" style="margin-top:0;">Donors</h1>
        <p class="section-sub">Data from <code>tblblooddonors</code>.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">+ New donor</a>
</div>

<div class="card" style="overflow-x:auto;">
    @if($donors->isEmpty())
        <p style="margin:0;color:#6b5a5e;">No donors yet. Register the first one.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donors as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->first_name }} {{ $d->last_name }}</td>
                        <td><span class="badge">{{ $d->blood_type }}</span></td>
                        <td>{{ $d->gender ?? '—' }}</td>
                        <td>{{ $d->status }}</td>
                        <td>{{ $d->address ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
