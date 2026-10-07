@extends('layouts.blood')
@section('title', $page->page_title)
@section('content')

<div style="max-width:40rem;margin:0 auto;text-align:center;">
    <p class="section-sub" style="margin:0 0 0.25rem;">
        <a href="{{ route('blood.pages') }}" style="color:var(--blood);font-weight:700;">← Pages</a>
        <span style="color:var(--muted);"> / </span>
        <code>{{ $page->page_slug }}</code>
    </p>
    <h1 class="section-title" style="font-size:1.4rem;margin-bottom:0.75rem;">{{ $page->page_title }}</h1>

    <div class="panel" style="text-align:left;">
        <div style="white-space:pre-wrap;font-size:0.95rem;line-height:1.7;color:var(--ink);">{{ $page->page_content }}</div>
    </div>

    <div style="margin-top:0.85rem;display:flex;flex-wrap:wrap;gap:0.4rem;justify-content:center;">
        <a class="btn btn-ghost" href="{{ route('blood.pages') }}">All pages</a>
        <a class="btn btn-primary" href="{{ route('blood.home') }}">Home</a>
        <a class="btn btn-ghost" href="{{ route('blood.contact') }}">Contact</a>
    </div>
</div>

@endsection
