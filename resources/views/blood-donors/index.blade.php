@extends('layouts.blood')
@section('title', 'Donors')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Blood donors</h1>
        <p class="section-sub">People registered to donate. Blood type is shown for quick matching.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">+ New donor</a>
</div>

<form method="GET" action="{{ route('blood.donors') }}" class="filter-bar">
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
        <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Clear filter</a>
    @endif
</form>

@if($donors->isEmpty())
    <div class="card empty">
        <div class="empty-icon">🩸</div>
        @if($bloodType)
            <h3>No {{ $bloodType }} donors yet</h3>
            <p>Try a different blood type, or check back later.</p>
            <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Clear filter</a>
        @else
            <h3>No donors yet</h3>
            <p>Be the first to register and help someone in need.</p>
            <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">Register as a donor</a>
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
                    <th>Blood type</th>
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
