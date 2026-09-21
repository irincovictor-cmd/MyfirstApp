@extends('blood.layout')

@section('title', 'Home')

@section('content')
<div class="hero">
    <div class="hero-kicker">Blood donation system</div>
    <h1>Give blood. Save lives.</h1>
    <p>Register as a donor or request blood. Every record is stored in MySQL and visible on the lists and admin dashboard.</p>
    <div class="hero-actions">
        <a class="btn btn-light" href="{{ route('blood.donor.create') }}">Become a Donor</a>
        <a class="btn btn-outline" href="{{ route('blood.request.create') }}">Request Blood</a>
    </div>
</div>

<h2 class="section-title">How we help</h2>
<p class="section-sub">A simple flow from form → controller → database table.</p>

<div class="grid-3">
    <div class="card">
        <div class="stat">{{ $donorCount }}</div>
        <h3>Registered donors</h3>
        <p>Saved in <code>tblblooddonors</code>.</p>
    </div>
    <div class="card">
        <div class="stat">{{ $requestCount }}</div>
        <h3>Blood requests</h3>
        <p>Saved in <code>tblrequirer</code>.</p>
    </div>
    <div class="card">
        <div class="stat">{{ $pageCount }}</div>
        <h3>Info pages</h3>
        <p>Saved in <code>tblpages</code>.</p>
    </div>
</div>

<div class="grid-3" style="margin-top:1rem;">
    <div class="card">
        <h3>1. Register</h3>
        <p>Donors and requesters submit forms on the site.</p>
    </div>
    <div class="card">
        <h3>2. Store</h3>
        <p>Laravel validates and writes to the blood ERD tables.</p>
    </div>
    <div class="card">
        <h3>3. Review</h3>
        <p>Lists and Admin dashboard read the same database.</p>
    </div>
</div>
@endsection
