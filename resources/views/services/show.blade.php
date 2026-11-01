@extends('layouts.public')

@section('title', $pageTitle)

@section('meta_description', $metaDescription)

@section('content')
@php
    $region = $site['region_label'] ?? 'Delhi NCR';
    $heroImage = $service->cardImageUrl() ?? asset('assets/images/repaircares-hero-ac.jpg');
    $serviceWaUrl = \App\Support\WhatsAppLink::url(\App\Support\WhatsAppLink::chatMessage($service->displayTitle()));
@endphp

<nav class="service-breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <span class="sep">/</span>
        <a href="{{ route('home') }}#featured">Services</a>
        <span class="sep">/</span>
        <span>{{ $service->displayTitle() }}</span>
    </div>
</nav>

<section class="detail-hero">
    <div class="detail-hero-bg" style="background-image:url('{{ $heroImage }}')"></div>
    <div class="detail-hero-overlay"></div>
    <div class="container detail-hero-inner">
        <div class="detail-hero-content">
            <div class="hero-badge detail-badge"><i class="fa-solid fa-circle-check"></i> {{ $region }} doorstep service</div>
            <h1>{{ $service->displayTitle() }} in <span class="detail-city">{{ $region }}</span></h1>
            <div class="detail-hero-meta">
                <span><i class="fa-solid fa-star"></i> <strong>{{ number_format($service->rating, 1) }}</strong> rating</span>
                <span><i class="fa-solid fa-shield-halved"></i> {{ $service->warranty_days }}-day warranty</span>
                <span><i class="fa-solid fa-bolt"></i> {{ $service->duration_mins }}-min express arrival</span>
            </div>
        </div>
        <div class="detail-hero-price-card">
            <div class="detail-price-label">Starts at</div>
            <div class="detail-price-row">
                <span class="original-price">₹{{ number_format($service->price_original, 0) }}</span>
                <span class="discounted-price">₹{{ number_format($service->price_sale, 0) }}</span>
                @if($service->discountPercent() > 0)
                    <span class="discount-badge">{{ $service->discountPercent() }}% OFF</span>
                @endif
            </div>
            <button type="button" class="btn-book-now js-open-booking"
                data-service-id="{{ $service->id }}"
                data-service-name="{{ $service->displayTitle() }}"
                data-service-price="₹{{ number_format($service->price_sale, 0) }}">BOOK NOW</button>
        </div>
    </div>
</section>

<section class="service-choice-band">
    <div class="container">
        <div class="choice-cards-grid">
            <div class="choice-card active">
                <div class="choice-img-wrapper choice-img-wrapper--subject">
                    @if($service->listingImageUrl())
                        <img src="{{ $service->listingImageUrl() }}" alt="" class="choice-img">
                    @endif
                </div>
                <div class="choice-title">Repair &amp; Troubleshooting</div>
            </div>
            <div class="choice-card">
                <div class="choice-img-wrapper">
                    @if($service->cardImageUrl())
                        <img src="{{ $service->cardImageUrl() }}" alt="" class="choice-img">
                    @endif
                </div>
                <div class="choice-title">Deep Service / Maintenance</div>
            </div>
            <div class="choice-card">
                <div class="choice-img-wrapper">
                    <img src="{{ asset($site['logo_path'] ?? 'assets/images/repair-care-logo.jpg') }}" alt="Repair Cares" class="choice-img choice-img--brand">
                </div>
                <div class="choice-title">Installation &amp; Setup</div>
            </div>
        </div>
    </div>
</section>

<section class="section-wrapper">
    <div class="container detail-layout">
        <div class="detail-main">
            <div class="sahil-rate-card highlight-rate-card">
                <div class="sahil-rate-card-img-wrapper">
                    @if($service->cardImageUrl())
                        <img src="{{ $service->cardImageUrl() }}" alt="{{ $service->displayTitle() }}" class="sahil-rate-card-img">
                    @endif
                    <div class="sahil-rate-card-rating"><i class="fa-solid fa-star"></i> {{ number_format($service->rating, 1) }}</div>
                </div>
                <div class="sahil-rate-card-body">
                    <h2>{{ $service->displayTitle() }}</h2>
                    <p class="detail-lead">{{ $service->short_description }}</p>
                    <div class="product-meta-strip">
                        <div class="product-meta-item"><i class="fa-solid fa-clock"></i> {{ $service->duration_mins }} mins visit</div>
                        <div class="product-meta-item"><i class="fa-solid fa-shield-halved"></i> {{ $service->warranty_days }} days warranty</div>
                        <div class="product-meta-item"><i class="fa-solid fa-user-check"></i> Verified technicians</div>
                    </div>
                    <div class="product-price-strip" style="margin-top:12px;">
                        <span class="original-price">₹{{ number_format($service->price_original, 0) }}</span>
                        <span class="discounted-price">₹{{ number_format($service->price_sale, 0) }}</span>
                    </div>
                    <button type="button" class="btn-book-now js-open-booking" style="margin-top:14px;max-width:280px;"
                        data-service-id="{{ $service->id }}"
                        data-service-name="{{ $service->displayTitle() }}"
                        data-service-price="₹{{ number_format($service->price_sale, 0) }}">Book via WhatsApp</button>
                </div>
            </div>

            <div class="detail-content-block">
                <h3>Service overview</h3>
                @if($service->detail_content)
                    <div class="detail-prose">{!! $service->detail_content !!}</div>
                @else
                    <div class="detail-prose">
                        <p>Book trusted {{ $service->displayTitle() }} professionals across {{ $region }}. Our technicians arrive at your doorstep with genuine tools, share an upfront quote before work begins, and complete the job with a {{ $service->warranty_days }}-day service warranty.</p>
                        <ul>
                            <li>Same-day &amp; scheduled slot booking</li>
                            <li>Police-verified &amp; experienced technicians</li>
                            <li>Transparent pricing — no hidden charges</li>
                            <li>WhatsApp booking confirmation &amp; support</li>
                        </ul>
                    </div>
                @endif
            </div>

            <div class="detail-content-block">
                <h3>How booking works</h3>
                <ol class="detail-steps-list">
                    <li>Select date &amp; time and confirm via WhatsApp</li>
                    <li>Technician visits your location in ~{{ $service->duration_mins }} minutes</li>
                    <li>Inspection, upfront estimate, then repair/service</li>
                    <li>Pay after service &amp; enjoy warranty support</li>
                </ol>
            </div>
        </div>

        <aside class="detail-sidebar">
            @include('partials.booking-form', [
                'services' => $allServices,
                'timeSlots' => $timeSlots,
                'cities' => $cities,
                'site' => $site,
                'selectedServiceId' => $service->id,
            ])
        </aside>
    </div>
</section>

<section class="service-action-band">
    <div class="container service-action-inner">
        <div class="service-action-copy">
            <strong>{{ $service->displayTitle() }}</strong>
            <span>From ₹{{ number_format($service->price_sale, 0) }} · {{ $service->duration_mins }}-min doorstep visit · {{ $service->warranty_days }}-day warranty</span>
        </div>
        <div class="service-action-buttons">
            <button type="button" class="btn btn-primary js-open-booking"
                data-service-id="{{ $service->id }}"
                data-service-name="{{ $service->displayTitle() }}"
                data-service-price="₹{{ number_format($service->price_sale, 0) }}">Book now</button>
            @if($serviceWaUrl)
                <a href="{{ $serviceWaUrl }}" class="btn btn-whatsapp" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp</a>
            @endif
            <a href="{{ route('home') }}#featured" class="btn btn-outline">Explore all services</a>
        </div>
    </div>
</section>

@if($related->isNotEmpty())
<section class="section-wrapper alt-bg">
    <div class="container">
        <div class="section-head-center">
            <h2>Related services</h2>
            <p>Other popular doorstep services in {{ $region }}</p>
        </div>
        <div class="product-cards-grid">
            @foreach($related as $item)
                <article class="sahil-product-card">
                    <a href="{{ route('services.show', $item->slug) }}" class="product-card-link">
                        <div class="product-img-wrapper product-img-wrapper--subject">
                            @if($item->listingImageUrl())
                                <img src="{{ $item->listingImageUrl() }}" alt="{{ $item->displayTitle() }}" class="product-card-img" loading="lazy">
                            @else
                                <span class="product-card-img product-card-img--placeholder" aria-hidden="true">{{ $item->icon ?? '🔧' }}</span>
                            @endif
                            <div class="product-rating-tag"><i class="fa-solid fa-star"></i> {{ number_format($item->rating, 1) }}</div>
                        </div>
                        <div class="product-card-body">
                            <div class="product-card-title">{{ $item->displayTitle() }}</div>
                            <div class="product-price-strip">
                                <span class="discounted-price">₹{{ number_format($item->price_sale, 0) }}</span>
                                <span class="original-price">₹{{ number_format($item->price_original, 0) }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="product-card-body" style="padding-top:0;">
                        <button type="button" class="btn-book-now js-open-booking"
                            data-service-id="{{ $item->id }}"
                            data-service-name="{{ $item->displayTitle() }}"
                            data-service-price="₹{{ number_format($item->price_sale, 0) }}">BOOK NOW</button>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.site-footer')
@endsection
