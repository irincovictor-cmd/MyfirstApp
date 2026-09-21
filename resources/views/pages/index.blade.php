@extends('layouts.blood')
@section('title', 'Pages')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Pages</h1>
        <p class="section-sub">pages/index · <code>tblpages</code></p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.page.create') }}">+ New page</a>
</div>
<div class="grid-3">
@forelse($pages ?? [] as $page)
    <article class="card">
        <h3 style="margin:0 0 .4rem;">{{ $page->page_title }}</h3>
        <p style="margin:0 0 .4rem;"><code>{{ $page->page_slug }}</code></p>
        <p style="margin:0;color:#6b5a5e;">{{ \Illuminate\Support\Str::limit($page->page_content, 120) }}</p>
    </article>
@empty
    <div class="card"><p style="margin:0;color:#6b5a5e;">No pages yet.</p></div>
@endforelse
</div>
@endsection
