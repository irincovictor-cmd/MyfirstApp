@extends('layouts.blood')
@section('title', 'Contact Queries')
@section('content')
<div class="head-row">
    <div>
        <h1 class="section-title">Contact queries</h1>
        <p class="section-sub">contact-queries/index · <code>tblcontactusquery</code></p>
    </div>
    <a class="btn btn-primary" href="{{ route('blood.contact') }}">+ New message</a>
</div>
<div class="card">
@forelse(($messages ?? collect()) as $m)
    <p style="margin:.6rem 0;border-bottom:1px solid #eadfdc;padding-bottom:.6rem;">
        <strong>{{ $m->name }}</strong> ({{ $m->email }}) — {{ $m->subject ?? 'No subject' }}<br>
        <span style="color:#6b5a5e;">{{ \Illuminate\Support\Str::limit($m->message, 100) }}</span>
    </p>
@empty
    <p style="margin:0;color:#6b5a5e;">No messages yet.</p>
@endforelse
</div>
@endsection
