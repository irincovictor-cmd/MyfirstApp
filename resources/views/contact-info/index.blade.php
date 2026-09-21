@extends('layouts.blood')
@section('title', 'Contact Info')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Contact info</h1>
        <p class="section-sub">contact-info/index · <code>tblcontactinfo</code></p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.contact-info.create') }}">+ Add</a>
</div>
<div class="card" style="overflow-x:auto;">
@if(($items ?? collect())->isEmpty())
    <p style="margin:0;color:#6b5a5e;">No contact info rows yet.</p>
@else
<table>
    <thead><tr><th>ID</th><th>Donor ID</th><th>Requirer ID</th><th>Phone</th><th>Email</th><th>Person</th></tr></thead>
    <tbody>
    @foreach($items as $i)
        <tr>
            <td>{{ $i->id }}</td>
            <td>{{ $i->blooddonor_id ?? '—' }}</td>
            <td>{{ $i->requirer_id ?? '—' }}</td>
            <td>{{ $i->phone ?? '—' }}</td>
            <td>{{ $i->email ?? '—' }}</td>
            <td>{{ $i->contact_person ?? '—' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
</div>
@endsection
