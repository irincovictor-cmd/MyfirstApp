@extends('layouts.blood')
@section('title', $page->page_title)
@section('content')

<div class="head-row" style="margin-bottom:0.5rem;">
    <div>
        <p class="section-sub" style="margin:0 0 0.15rem;">
            <a href="{{ route('blood.pages') }}" style="color:var(--blood);font-weight:700;">← Pages</a>
            <span style="color:var(--muted);"> / </span>
            <code>{{ $page->page_slug }}</code>
        </p>
        <h1 class="section-title" style="font-size:1.35rem;">{{ $page->page_title }}</h1>
    </div>
</div>

<div class="panel" style="max-width:48rem;margin-top:0.35rem;">
    <div style="white-space:pre-wrap;font-size:0.95rem;line-height:1.7;color:var(--ink);">{{ $page->page_content }}</div>
</div>

<div style="margin-top:0.85rem;display:flex;flex-wrap:wrap;gap:0.4rem;">
    <a class="btn btn-ghost" href="{{ route('blood.pages') }}">All pages</a>
    <a class="btn btn-primary" href="{{ route('blood.home') }}">Home</a>
    <a class="btn btn-ghost" href="{{ route('blood.contact') }}">Contact</a>
</div>

@endsection
