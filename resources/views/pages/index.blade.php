@extends('layouts.blood')
@section('title', 'Pages')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Info pages</h1>
        <p class="section-sub">Content pages managed for the blood donation site.</p>
    </div>
    @auth
        @if(auth()->user()->role === 'admin')
            <a class="btn btn-primary" href="{{ route('blood.page.create') }}" style="padding: 0.55rem 1rem; font-size: 0.88rem;">
                + New page
            </a>
        @endif
    @endauth
</div>

@if(($pages ?? collect())->isEmpty())
    <div class="card" style="text-align: center; padding: 2rem 1.5rem;">
        <p style="font-size: 1.75rem; margin: 0 0 0.5rem;">📄</p>
        <h3 style="margin: 0 0 0.4rem;">No pages yet</h3>
        <p style="color: var(--muted); margin: 0 0 1rem;">Create an about, FAQ, or guidelines page for visitors.</p>
        @auth
            @if(auth()->user()->role === 'admin')
                <a class="btn btn-primary" href="{{ route('blood.page.create') }}" style="padding: 0.55rem 1rem; font-size: 0.88rem;">
                    Create a page
                </a>
            @endif
        @endauth
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
