@extends('blood.layout')

@section('title', 'Become a Donor')

@section('content')
<h1 class="section-title" style="margin-top:0;">Become a donor</h1>
<p class="section-sub">Saves to <code>tblblooddonors</code> (linked to <code>tbladmin</code> automatically).</p>

<div class="card" style="max-width:32rem;">
    <form method="POST" action="{{ route('blood.donor.store') }}">
        @csrf
        <label for="first_name">First name</label>
        <input id="first_name" name="first_name" value="{{ old('first_name') }}" required>

        <label for="last_name">Last name</label>
        <input id="last_name" name="last_name" value="{{ old('last_name') }}" required>

        <label for="blood_type">Blood type</label>
        <select id="blood_type" name="blood_type" required>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                <option value="{{ $t }}" @selected(old('blood_type')===$t)>{{ $t }}</option>
            @endforeach
        </select>

        <label for="birth_date">Birth date</label>
        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}">

        <label for="gender">Gender</label>
        <select id="gender" name="gender">
            <option value="">—</option>
            <option value="Male" @selected(old('gender')==='Male')>Male</option>
            <option value="Female" @selected(old('gender')==='Female')>Female</option>
            <option value="Other" @selected(old('gender')==='Other')>Other</option>
        </select>

        <label for="address">Address</label>
        <input id="address" name="address" value="{{ old('address') }}">

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Submit registration</button>
            <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
