@extends('layouts.blood')
@section('title', 'Donors')
@section('content')

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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $donors->links('vendor.pagination.custom') }}
@endif

@endsection
