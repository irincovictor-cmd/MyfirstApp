@extends('layouts.blood')
@section('title', 'Create Donor')
@section('content')
<h1 class="section-title">Become a donor</h1>
<p class="section-sub">create.blade.php · saves to <code>tblblooddonors</code></p>
<div class="card" style="max-width:32rem;">
<form method="POST" action="{{ route('blood.donor.store') }}">
    @csrf
    <label>First name</label>
    <input name="first_name" value="{{ old('first_name') }}" required>
    <label>Last name</label>
    <input name="last_name" value="{{ old('last_name') }}" required>
    <label>Blood type</label>
    <select name="blood_type" required>
        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
            <option value="{{ $t }}" @selected(old('blood_type')===$t)>{{ $t }}</option>
        @endforeach
    </select>
    <label>Birth date</label>
    <input type="date" name="birth_date" value="{{ old('birth_date') }}">
    <label>Gender</label>
    <select name="gender">
        <option value="">—</option>
        <option value="Male" @selected(old('gender')==='Male')>Male</option>
        <option value="Female" @selected(old('gender')==='Female')>Female</option>
        <option value="Other" @selected(old('gender')==='Other')>Other</option>
    </select>
    <label>Address</label>
    <input name="address" value="{{ old('address') }}">
    <div class="form-actions">
        <button class="btn btn-primary" type="submit">Submit</button>
        <a class="btn btn-ghost" href="{{ route('blood.donors') }}">Back to list</a>
    </div>
</form>
</div>
@endsection
