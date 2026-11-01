@extends('layouts.public')

@section('title', $page->title.' | '.($site['site_name'] ?? ''))

@section('content')
<div class="container page-content">
    <h1>{{ $page->title }}</h1>
    <div class="page-prose">{!! $page->content !!}</div>

    <div class="page-cta-strip">
        <p>Ready to book a verified technician at your doorstep?</p>
        <div class="page-cta-actions">
            <button type="button" class="btn btn-primary js-open-booking"><i class="fa-solid fa-calendar-check"></i> Book a service</button>
            @if($whatsappChatUrl ?? null)
                <a href="{{ $whatsappChatUrl }}" class="btn btn-whatsapp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp us</a>
            @endif
            <a href="{{ route('home') }}#featured" class="btn btn-outline">Browse services</a>
        </div>
    </div>

    <p class="page-back-link"><a href="{{ route('home') }}">← Back to home</a></p>
</div>

@include('partials.site-footer')
@endsection
