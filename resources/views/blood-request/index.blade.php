@extends('layouts.blood')
@section('title', 'Blood Requests')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Blood requests</h1>
        <p class="section-sub">Open needs from patients and hospitals, soonest-needed first.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.request.create') }}">+ New request</a>
</div>

<form method="GET" action="{{ route('blood.requests') }}" class="filter-bar">
    <div class="field">
        <label for="blood_type">Filter by blood type</label>
        <select id="blood_type" name="blood_type" onchange="this.form.submit()">
            <option value="">All types</option>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                <option value="{{ $t }}" @selected($bloodType === $t)>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    @if($bloodType)
        <a class="btn btn-ghost" href="{{ route('blood.requests') }}">Clear filter</a>
    @endif
</form>

@if($requirers->isEmpty())
    <div class="card empty">
        <div class="empty-icon">📋</div>
        @if($bloodType)
            <h3>No {{ $bloodType }} requests yet</h3>
            <p>Try a different blood type, or check back later.</p>
            <a class="btn btn-ghost" href="{{ route('blood.requests') }}">Clear filter</a>
        @else
            <h3>No blood requests yet</h3>
            <p>When someone needs blood, their request will appear here.</p>
            <a class="btn btn-primary" href="{{ route('blood.request.create') }}">Submit a request</a>
        @endif
    </div>
@else
    <p class="scroll-hint">Swipe left/right to see more columns &rarr;</p>
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
                    @php
                        $daysLeft = $r->required_date
                            ? (int) floor((strtotime($r->required_date) - strtotime('today')) / 86400)
                            : null;
                        $isUrgent = $daysLeft !== null && $daysLeft <= 2;
                    @endphp
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td><strong>{{ $r->first_name }} {{ $r->last_name }}</strong></td>
                        <td><span class="badge">{{ $r->blood_type }}</span></td>
                        <td>{{ $r->units_needed }}</td>
                        <td>{{ $r->hospital ?? '—' }}</td>
                        <td>
                            {{ $r->required_date ?? '—' }}
                            @if($isUrgent)
                                <span class="status status-urgent" style="margin-left:0.35rem;">Urgent</span>
                            @endif
                        </td>
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
    {{ $requirers->links('vendor.pagination.custom') }}
@endif
@endsection
