@extends('layouts.blood')
@section('title', 'Requests')
@section('content')

@php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp

<div class="head-row">
    <div>
        <h1 class="section-title">📋 Requests</h1>
        <p class="section-sub">Blood needs</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.request.create') }}">+ Request</a>
</div>

<form method="GET" action="{{ route('blood.requests') }}" class="filter-bar">
    <div class="field">
        <label for="blood_type">Blood type</label>
        <select id="blood_type" name="blood_type" onchange="this.form.submit()">
            <option value="">All</option>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                <option value="{{ $t }}" @selected(($bloodType ?? '') === $t)>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    @if(!empty($bloodType))
        <a class="btn btn-ghost" href="{{ route('blood.requests') }}">Clear</a>
    @endif
</form>

@if($requirers->isEmpty())
    <div class="card empty">
        <div class="empty-icon">📋</div>
        <h3>{{ !empty($bloodType) ? 'No '.$bloodType.' requests' : 'No requests' }}</h3>
        <p>{{ !empty($bloodType) ? 'Try another type.' : 'Add the first one.' }}</p>
        @if(!empty($bloodType))
            <a class="btn btn-ghost" href="{{ route('blood.requests') }}">Clear</a>
        @else
            <a class="btn btn-primary" href="{{ route('blood.request.create') }}">+ Request</a>
        @endif
    </div>
@else
    <p class="scroll-hint">Swipe for more columns →</p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Units</th>
                    <th>Hospital</th>
                    <th>Needed</th>
                    <th>Status</th>
                    @if($isAdmin)
                        <th>Actions</th>
                    @endif
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
                                <span class="badge" style="margin-left:0.25rem;">Urgent</span>
                            @endif
                        </td>
                        <td>
                            <span class="status status-{{ strtolower($r->status ?? 'pending') }}">
                                {{ $r->status ?? 'pending' }}
                            </span>
                        </td>
                        @if($isAdmin)
                            <td>
                                <div style="display:flex;flex-wrap:wrap;gap:0.25rem;">
                                    @if(($r->status ?? '') !== 'approved')
                                        <form method="POST" action="{{ route('blood.request.status', $r) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-primary" style="padding:0.25rem 0.45rem;font-size:0.72rem;">✓ Approve</button>
                                        </form>
                                    @endif
                                    @if(($r->status ?? '') !== 'fulfilled')
                                        <form method="POST" action="{{ route('blood.request.status', $r) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="fulfilled">
                                            <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;">✓ Fulfilled</button>
                                        </form>
                                    @endif
                                    @if(($r->status ?? '') !== 'rejected')
                                        <form method="POST" action="{{ route('blood.request.status', $r) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;">✗ Reject</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('blood.request.destroy', $r) }}" onsubmit="return confirm('Delete this request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;color:#9f1239;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $requirers->links('vendor.pagination.custom') }}
@endif

@endsection
