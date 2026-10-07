@extends('layouts.blood')
@section('title', $page->page_title)
@section('content')

<div class="head-row">
    <div>
        <h1 class="section-title">{{ $page->page_title }}</h1>
        <p class="section-sub"><code>{{ $page->page_slug }}</code></p>
    </div>
    <a class="btn btn-ghost" href="{{ route('blood.pages') }}">← All pages</a>
</div>

<div class="panel" style="max-width:40rem;">
    <div style="white-space:pre-wrap;font-size:0.95rem;line-height:1.65;color:var(--ink);">
{{ $page->page_content }}
    </div>
</div>

@endsection
