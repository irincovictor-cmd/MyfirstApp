@extends('layouts.blood')
@section('title', 'Pages')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Info pages</h1>
        <p class="section-sub">Content pages managed for the blood donation site.</p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.page.create') }}">+ New page</a>
</div>

@if(($pages ?? collect())->isEmpty())
    <div class="card empty">
        <div class="empty-icon">📄</div>
        <h3>No pages yet</h3>
        <p>Create an about, FAQ, or guidelines page for visitors.</p>
        <a class="btn btn-primary" href="{{ route('blood.page.create') }}">Create a page</a>
    </div>
@else
    <div class="grid-3">
        @foreach($pages as $page)
            <article class="card">
                <h3 style="margin:0 0 0.35rem;">{{ $page->page_title }}</h3>
                <p style="margin:0 0 0.5rem;"><code>{{ $page->page_slug }}</code></p>
                <p style="margin:0;">{{ \Illuminate\Support\Str::limit($page->page_content, 120) }}</p>
            </article>
        @endforeach
    </div>
@endif
@endsection
