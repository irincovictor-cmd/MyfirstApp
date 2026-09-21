@extends('layouts.blood')
@section('title', 'Requirers')
@section('content')
{{-- Same data as blood-request list; folder required by assignment --}}
<div class="head-row">
    <div>
        <h1 class="section-title">Requirers</h1>
        <p class="section-sub">requirers/index · <code>tblrequirer</code></p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.requirer.create') }}">+ Create</a>
</div>
<div class="card" style="overflow-x:auto;">
@if(($requirers ?? collect())->isEmpty())
    <p style="margin:0;color:#6b5a5e;">No requirers yet.</p>
@else
<table>
    <thead><tr><th>ID</th><th>Name</th><th>Blood</th><th>Units</th><th>Hospital</th><th>Status</th></tr></thead>
    <tbody>
    @foreach($requirers as $r)
        <tr>
            <td>{{ $r->id }}</td>
            <td>{{ $r->first_name }} {{ $r->last_name }}</td>
            <td><span class="badge">{{ $r->blood_type }}</span></td>
            <td>{{ $r->units_needed }}</td>
            <td>{{ $r->hospital ?? '—' }}</td>
            <td>{{ $r->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
</div>
@endsection
