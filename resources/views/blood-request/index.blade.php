@extends('layouts.blood')
@section('title', 'Blood Requests')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Blood requests</h1>
        <p class="section-sub">Open needs from patients and hospitals. Units and required date help prioritization.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.request.create') }}">+ New request</a>
</div>

@if(($requirers ?? collect())->isEmpty())
    <div class="card empty">
        <div class="empty-icon">📋</div>
        <h3>No blood requests yet</h3>
        <p>When someone needs blood, their request will appear here.</p>
        <a class="btn btn-primary" href="{{ route('blood.request.create') }}">Submit a request</a>
    </div>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Blood</th>
                    <th>Units</th>
                    <th>Hospital</th>
                    <th>Needed by</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requirers as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td><strong>{{ $r->first_name }} {{ $r->last_name }}</strong></td>
                        <td><span class="badge">{{ $r->blood_type }}</span></td>
                        <td>{{ $r->units_needed }}</td>
                        <td>{{ $r->hospital ?? '—' }}</td>
                        <td>{{ $r->required_date ?? '—' }}</td>
                        <td>
                            <span class="status status-{{ strtolower($r->status ?? 'pending') }}">
                                {{ $r->status ?? 'pending' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
