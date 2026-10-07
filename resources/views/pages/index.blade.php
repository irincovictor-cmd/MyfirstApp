@extends('layouts.blood')
@section('title', 'Pages')
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">📄 Pages</h1>
        <p class="section-sub">Guides and FAQ — click a card to read</p>
    </div>
    @auth
        @if(auth()->user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('blood.page.create') }}">+ Page</a>
        @endif
    @endauth
</div>

@if(($pages ?? collect())->isEmpty())
    <div class="card empty">
        <div class="empty-icon">📄</div>
        <h3>No pages</h3>
        <p>Refresh once — starter pages load automatically.</p>
    </div>
@else
    <div class="grid-2">
        @foreach($pages as $page)
            <a class="card quick-link" href="{{ route('blood.page.show', $page) }}" style="min-height:4.5rem;">
                <div class="feature-icon">📄</div>
                <div style="flex:1;">
                    <strong>{{ $page->page_title }}</strong>
                    <span>{{ \Illuminate\Support\Str::limit(strip_tags($page->page_content), 110) }}</span>
                </div>
            </a>
        @endforeach
    </div>
@endif

@endsection
