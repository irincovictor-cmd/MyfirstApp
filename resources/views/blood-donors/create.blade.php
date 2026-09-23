@extends('layouts.blood')
@section('title', 'Become a Donor')
@section('content')
<div class="form-page">
    <h1 class="section-title">Become a donor</h1>
    <p class="section-sub">Share your blood type and basic details. We’ll keep your record for matching.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.donor.store') }}">
            @csrf

            <div class="row-2">
                <div class="field">
                    <label for="first_name">First name</label>
                    <input id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="Juan">
                </div>
                <div class="field">
                    <label for="last_name">Last name</label>
                    <input id="last_name" name="last_name" value="{{ old('last_name') }}" required placeholder="Dela Cruz">
                </div>
            </div>

            <div class="row-2">
                <div class="field">
                    <label for="blood_type">Blood type</label>
                    <select id="blood_type" name="blood_type" required>
                        <option value="" disabled @selected(!old('blood_type'))>Select type</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                            <option value="{{ $t }}" @selected(old('blood_type')===$t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="">Prefer not to say</option>
                        <option value="Male" @selected(old('gender')==='Male')>Male</option>
                        <option value="Female" @selected(old('gender')==='Female')>Female</option>
                        <option value="Other" @selected(old('gender')==='Other')>Other</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label for="birth_date">Birth date <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
                <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}">
            </div>

            <div class="field">
                <label for="address">Address <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
                <input id="address" name="address" value="{{ old('address') }}" placeholder="City or area">
                <p class="hint">Helps match nearby requests.</p>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Submit registration</button>
                <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
