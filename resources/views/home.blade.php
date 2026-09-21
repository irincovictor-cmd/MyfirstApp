@extends('layouts.blood')

@section('title', 'Home')

@section('content')
<div class="hero">
    <div class="hero-kicker">Blood donation system</div>
    <h1>Give blood. Save lives.</h1>
    <p>Register as a donor or request blood. Records are stored in MySQL (tblblooddonors, tblrequirer, and related tables).</p>
    <div class="hero-actions">
        <a class="btn btn-light" href="{{ route('blood.donor.create') }}">Become a Donor</a>
        <a class="btn btn-outline" href="{{ route('blood.request.create') }}">Request Blood</a>
    </div>
</div>

<h2 class="section-title" style="margin-top:2rem;">How we help</h2>
<p class="section-sub">Form → controller → database table.</p>
<div class="grid-3">
    <div class="card"><div class="stat">{{ $donorCount ?? 0 }}</div><h3>Donors</h3><p>tblblooddonors</p></div>
    <div class="card"><div class="stat">{{ $requestCount ?? 0 }}</div><h3>Requests</h3><p>tblrequirer</p></div>
    <div class="card"><div class="stat">{{ $pageCount ?? 0 }}</div><h3>Pages</h3><p>tblpages</p></div>
</div>
@endsection
