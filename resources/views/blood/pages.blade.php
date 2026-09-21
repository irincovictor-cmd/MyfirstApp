@extends('blood.layout')

@section('title', 'Pages')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;">
    <div>
        <h1 class="section-title" style="margin-top:0;">Pages</h1>
        <p class="section-sub">Content from <code>tblpages</code>.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.page.create') }}">+ New page</a>
</div>

<div class="grid-3">
    @forelse($pages as $page)
        <article class="card">
            <h3>{{ $page->page_title }}</h3>
            <p style="margin-bottom:0.5rem;"><code>{{ $page->page_slug }}</code></p>
            <p>{{ \Illuminate\Support\Str::limit($page->page_content, 120) }}</p>
        </article>
    @empty
        <div class="card"><p style="margin:0;color:#6b5a5e;">No pages yet.</p></div>
    @endforelse
</div>
@endsection
