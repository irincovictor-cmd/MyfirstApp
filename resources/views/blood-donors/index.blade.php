@extends('layouts.blood')
@section('title', 'Donors')
@section('content')

@php $isAdmin = auth()->check() && auth()->user()->isAdmin(); @endphp

<div class="head-row">
    <div>
        <h1 class="section-title">🩸 Donors</h1>
        <p class="section-sub">Registered donors</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">+ Donor</a>
</div>

<form method="GET" action="{{ route('blood.donors') }}" class="filter-bar">
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
        <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Clear</a>
    @endif
</form>

@if($donors->isEmpty())
    <div class="card empty">
        <div class="empty-icon">🩸</div>
        <h3>{{ !empty($bloodType) ? 'No '.$bloodType.' donors' : 'No donors' }}</h3>
        <p>{{ !empty($bloodType) ? 'Try another type.' : 'Add the first one.' }}</p>
        @if(!empty($bloodType))
            <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Clear</a>
        @else
            <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">+ Donor</a>
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
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Address</th>
                    @if($isAdmin)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($donors as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td><strong>{{ $d->first_name }} {{ $d->last_name }}</strong></td>
                        <td><span class="badge">{{ $d->blood_type }}</span></td>
                        <td>{{ $d->gender ?? '—' }}</td>
                        <td>
                            <span class="status status-{{ strtolower($d->status ?? 'pending') }}">
                                {{ $d->status ?? 'pending' }}
                            </span>
                        </td>
                        <td>{{ $d->address ?? '—' }}</td>
                        @if($isAdmin)
                            <td>
                                <div style="display:flex;flex-wrap:wrap;gap:0.25rem;">
                                    @if(($d->status ?? '') !== 'approved')
                                        <form method="POST" action="{{ route('blood.donor.status', $d) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-primary" style="padding:0.25rem 0.45rem;font-size:0.72rem;">✓ Approve</button>
                                        </form>
                                    @endif
                                    @if(($d->status ?? '') !== 'rejected')
                                        <form method="POST" action="{{ route('blood.donor.status', $d) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;">✗ Reject</button>
                                        </form>
                                    @endif
                                    @if(($d->status ?? '') !== 'pending')
                                        <form method="POST" action="{{ route('blood.donor.status', $d) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-ghost" style="padding:0.25rem 0.45rem;font-size:0.72rem;">↺ Pending</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('blood.donor.destroy', $d) }}" onsubmit="return confirm('Delete this donor?');">
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
    {{ $donors->links('vendor.pagination.custom') }}
@endif

@endsection
