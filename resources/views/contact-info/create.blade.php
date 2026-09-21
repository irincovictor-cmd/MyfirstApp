@extends('layouts.blood')
@section('title', 'Create Contact Info')
@section('content')
<h1 class="section-title">Add contact info</h1>
<p class="section-sub">contact-info/create · <code>tblcontactinfo</code></p>
<div class="card" style="max-width:32rem;">
<form method="POST" action="{{ route('blood.contact-info.store') }}">
    @csrf
    <label>Blood donor</label>
    <select name="blooddonor_id">
        <option value="">— optional —</option>
        @foreach($donors ?? [] as $d)
            <option value="{{ $d->id }}">{{ $d->first_name }} {{ $d->last_name }}</option>
        @endforeach
    </select>
    <label>Requirer</label>
    <select name="requirer_id">
        <option value="">— optional —</option>
        @foreach($requirers ?? [] as $r)
            <option value="{{ $r->id }}">{{ $r->first_name }} {{ $r->last_name }}</option>
        @endforeach
    </select>
    <label>Phone</label>
    <input name="phone" value="{{ old('phone') }}">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}">
    <label>Contact person</label>
    <input name="contact_person" value="{{ old('contact_person') }}">
    <div class="form-actions">
        <button class="btn btn-primary" type="submit">Save</button>
        <a class="btn btn-ghost" href="{{ route('blood.contact-info.index') }}">Back</a>
    </div>
</form>
</div>
@endsection
