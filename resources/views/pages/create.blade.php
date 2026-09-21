@extends('layouts.blood')
@section('title', 'Create Page')
@section('content')
<h1 class="section-title">Create page</h1>
<p class="section-sub">pages/create · <code>tblpages</code></p>
<div class="card" style="max-width:36rem;">
<form method="POST" action="{{ route('blood.page.store') }}">
    @csrf
    <label>Title</label>
    <input name="page_title" value="{{ old('page_title') }}" required>
    <label>Slug (optional)</label>
    <input name="page_slug" value="{{ old('page_slug') }}" placeholder="auto if empty">
    <label>Content</label>
    <textarea name="page_content" rows="6">{{ old('page_content') }}</textarea>
    <div class="form-actions">
        <button class="btn btn-primary" type="submit">Save page</button>
        <a class="btn btn-ghost" href="{{ route('blood.pages') }}">Back</a>
    </div>
</form>
</div>
@endsection
