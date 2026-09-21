@extends('blood.layout')

@section('title', 'Request Blood')

@section('content')
<h1 class="section-title" style="margin-top:0;">Request blood</h1>
<p class="section-sub">Saves to <code>tblrequirer</code>.</p>

<div class="card" style="max-width:32rem;">
    <form method="POST" action="{{ route('blood.request.store') }}">
        @csrf
        <label for="first_name">First name</label>
        <input id="first_name" name="first_name" value="{{ old('first_name') }}" required>

        <label for="last_name">Last name</label>
        <input id="last_name" name="last_name" value="{{ old('last_name') }}" required>

        <label for="blood_type">Blood type needed</label>
        <select id="blood_type" name="blood_type" required>
            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
                <option value="{{ $t }}" @selected(old('blood_type')===$t)>{{ $t }}</option>
            @endforeach
        </select>

        <label for="units_needed">Units needed</label>
        <input id="units_needed" type="number" min="1" name="units_needed" value="{{ old('units_needed', 1) }}">

        <label for="required_date">Required date</label>
        <input id="required_date" type="date" name="required_date" value="{{ old('required_date') }}">

        <label for="hospital">Hospital</label>
        <input id="hospital" name="hospital" value="{{ old('hospital') }}">

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Submit request</button>
            <a class="btn btn-ghost" href="{{ route('blood.requests') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
