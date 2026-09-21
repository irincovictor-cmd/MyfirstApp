@extends('layouts.blood')
@section('title', 'Blood Requests')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Blood requests</h1>
        <p class="section-sub">blood-request/index · <code>tblrequirer</code></p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.request.create') }}">+ New request</a>
</div>
<div class="card" style="overflow-x:auto;">
@if(($requirers ?? collect())->isEmpty())
    <p style="margin:0;color:#6b5a5e;">No requests yet.</p>
@else
<table>
    <thead><tr><th>ID</th><th>Name</th><th>Blood</th><th>Units</th><th>Hospital</th><th>Date</th><th>Status</th></tr></thead>
    <tbody>
    @foreach($requirers as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->first_name }} {{ $r->last_name }}</td>
            <td><span class="badge">{{ $r->blood_type }}</span></td>
            <td>{{ $r->units_needed }}</td>
            <td>{{ $r->hospital ?? '—' }}</td>
            <td>{{ $r->required_date ?? '—' }}</td>
            <td>{{ $r->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
</div>
@endsection
