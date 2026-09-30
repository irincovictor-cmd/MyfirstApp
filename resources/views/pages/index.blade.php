@extends('layouts.blood')
@section('title', 'Pages')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Info pages</h1>
        <p class="section-sub">Content pages for the blood donation site.</p>
    </div>
    @auth
        @if(auth()->user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('blood.page.create') }}">+ New page</a>
        @endif
    @endauth
</div>

@if(($pages ?? collect())->isEmpty())
    <div class="card empty">
        <div class="empty-icon">📄</div>
        <h3>No pages yet</h3>
        <p>Create an about, FAQ, or guidelines page for visitors.</p>
        @auth
            @if(auth()->user()->isAdmin())
                <a class="btn btn-primary" href="{{ route('blood.page.create') }}">Create a page</a>
            @endif
        @endauth
    </div>
@else
    <div class="grid-3">
        @foreach($pages as $page)
            <article class="card">
                <h3>{{ $page->page_title }}</h3>
                <p style="margin:0 0 0.4rem;"><code>{{ $page->page_slug }}</code></p>
                <p>{{ \Illuminate\Support\Str::limit($page->page_content, 120) }}</p>
            </article>
        @endforeach
    </div>
@endif
@endsection
