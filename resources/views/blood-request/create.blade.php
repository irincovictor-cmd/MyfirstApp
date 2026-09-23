@extends('layouts.blood')
@section('title', 'Request Blood')
@section('content')
<div class="form-page">
    <h1 class="section-title">Request blood</h1>
    <p class="section-sub">Tell us the blood type, units needed, and where it should go.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('blood.request.store') }}">
            @csrf

            <div class="row-2">
                <div class="field">
                    <label for="first_name">First name</label>
                    <input id="first_name" name="first_name" value="{{ old('first_name') }}" required placeholder="Patient or contact">
                </div>
                <div class="field">
                    <label for="last_name">Last name</label>
                    <input id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div class="row-2">
                <div class="field">
                    <label for="blood_type">Blood type needed</label>
                    <select id="blood_type" name="blood_type" required>
                        <option value="" disabled @selected(!old('blood_type'))>Select type</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                            <option value="{{ $t }}" @selected(old('blood_type')===$t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label for="units_needed">Units needed</label>
                    <input id="units_needed" type="number" min="1" name="units_needed" value="{{ old('units_needed', 1) }}" required>
                </div>
            </div>

            <div class="field">
                <label for="required_date">Required by <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
                <input id="required_date" type="date" name="required_date" value="{{ old('required_date') }}">
            </div>

            <div class="field">
                <label for="hospital">Hospital / facility <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
                <input id="hospital" name="hospital" value="{{ old('hospital') }}" placeholder="e.g. City General Hospital">
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">Submit request</button>
                <a class="btn btn-ghost" href="{{ route('blood.requests') }}">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
