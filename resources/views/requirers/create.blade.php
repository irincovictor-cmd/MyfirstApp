@extends('layouts.blood')
@section('title', 'Create Requirer')
@section('content')
<h1 class="section-title">Create requirer</h1>
<p class="section-sub">requirers/create · <code>tblrequirer</code></p>
<div class="card" style="max-width:32rem;">
<form method="POST" action="{{ route('blood.request.store') }}">
    @csrf
    <label>First name</label>
    <input name="first_name" value="{{ old('first_name') }}" required>
    <label>Last name</label>
    <input name="last_name" value="{{ old('last_name') }}" required>
    <label>Blood type</label>
    <select name="blood_type" required>
        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $t)
            <option value="{{ $t }}">{{ $t }}</option>
        @endforeach
    </select>
    <label>Units needed</label>
    <input type="number" min="1" name="units_needed" value="1">
    <label>Required date</label>
    <input type="date" name="required_date">
    <label>Hospital</label>
    <input name="hospital">
    <div class="form-actions">
        <button class="btn btn-primary" type="submit">Save</button>
        <a class="btn btn-ghost" href="{{ route('blood.requirers') }}">Back</a>
    </div>
</form>
</div>
@endsection
