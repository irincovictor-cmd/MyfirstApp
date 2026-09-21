@extends('blood.layout')

@section('title', 'New Page')

@section('content')
<h1 class="section-title" style="margin-top:0;">Create page</h1>
<p class="section-sub">Saves to <code>tblpages</code>.</p>

<div class="card" style="max-width:36rem;">
    <form method="POST" action="{{ route('blood.page.store') }}">
        @csrf
        <label for="page_title">Title</label>
        <input id="page_title" name="page_title" value="{{ old('page_title') }}" required>

        <label for="page_slug">Slug (optional)</label>
        <input id="page_slug" name="page_slug" value="{{ old('page_slug') }}" placeholder="auto-generated if empty">

        <label for="page_content">Content</label>
        <textarea id="page_content" name="page_content" rows="6">{{ old('page_content') }}</textarea>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save page</button>
            <a class="btn btn-ghost" href="{{ route('blood.pages') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
