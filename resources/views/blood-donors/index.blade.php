@extends('layouts.blood')
@section('title', 'Donors')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Blood donors</h1>
        <p class="section-sub">index.blade.php · table <code>tblblooddonors</code></p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">+ New donor</a>
</div>
<div class="card" style="overflow-x:auto;">
@if(($donors ?? collect())->isEmpty())
    <p style="margin:0;color:#6b5a5e;">No donors yet.</p>
@else
<table>
    <thead><tr><th>ID</th><th>Name</th><th>Blood</th><th>Gender</th><th>Status</th><th>Address</th></tr></thead>
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
