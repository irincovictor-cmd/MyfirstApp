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

@if(($donors ?? collect())->isEmpty())
    <div class="card empty">
        <div class="empty-icon">🩸</div>
        <h3>No donors yet</h3>
        <p>Be the first to register and help someone in need.</p>
        <a class="btn btn-primary" href="{{ route('blood.donor.create') }}">Register as a donor</a>
    </div>
@else
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
@endif
@endsection
