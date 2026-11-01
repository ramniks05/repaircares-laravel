@extends('layouts.public')

@section('title', ($site['site_name'] ?? 'Home Services').' | Expert Home Appliance Repair in '.($site['region_label'] ?? 'Delhi NCR'))

@section('content')
@php
    $amcWaUrl = \App\Support\WhatsAppLink::url('AMC plan enquiry — '.($site['site_name'] ?? ''));
@endphp

@include('partials.hero-slider', ['heroSlides' => $heroSlides])

<span id="booking" class="page-anchor" aria-hidden="true"></span>

@push('scripts')
    <script src="{{ asset('js/hero-slider.js') }}?v=3"></script>
@endpush

<section class="section-wrapper alt-bg home-services-section">
    <div class="container">
        <div class="section-head-center">
            <div class="section-kicker">Services</div>
            <h2>Our Services</h2>
            <p>{{ $site['services_intro'] }}</p>
        </div>
        <div class="sahil-services-grid">
            @foreach($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="sahil-cat-card">
                    @if($service->listingImageUrl())
                        <img src="{{ $service->listingImageUrl() }}" alt="{{ $service->name }}" loading="lazy">
                    @else
                        <div style="aspect-ratio:1;display:grid;place-items:center;font-size:2rem;background:#fff1f2;">{{ $service->icon ?? '🔧' }}</div>
                    @endif
                    <h3>{{ $service->displayTitle() }}</h3>
                    <span>SERVICES</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section-wrapper" id="featured">
    <div class="container">
        <div class="section-head-center">
            <div class="section-kicker">Helpline {{ $site['helpline'] ?? '' }}</div>
            <h2>Most Booked Services</h2>
            <p>{{ $site['featured_intro'] ?? 'Top rated door-step repair solutions in '.($site['region_label'] ?? 'Delhi NCR') }}</p>
        </div>
        <div class="product-cards-grid">
            @foreach($featuredServices as $service)
                <article class="sahil-product-card">
                    <a href="{{ route('services.show', $service->slug) }}" class="product-card-link">
                    <div class="product-img-wrapper">
                        @if($service->cardImageUrl())
                            <img src="{{ $service->cardImageUrl() }}" alt="{{ $service->name }}" class="product-card-img" loading="lazy">
                        @else
                            <div class="product-card-img" style="display:grid;place-items:center;background:#fff1f2;font-size:3rem;">{{ $service->icon }}</div>
                        @endif
                        <div class="product-rating-tag"><i class="fa-solid fa-star"></i> {{ number_format($service->rating, 1) }}</div>
                    </div>
                    <div class="product-card-body" style="padding-bottom:0;">
                        <div class="product-card-title">{{ $service->displayTitle() }}</div>
                        <div class="product-price-strip">
                            <span class="original-price">₹{{ number_format($service->price_original, 0) }}</span>
                            <span class="discounted-price">₹{{ number_format($service->price_sale, 0) }}</span>
                            @if($service->discountPercent() > 0)
                                <span class="discount-badge"><i class="fa-solid fa-arrow-down"></i> {{ $service->discountPercent() }}% OFF</span>
                            @endif
                        </div>
                        <div class="product-meta-strip">
                            <div class="product-meta-item"><i class="fa-solid fa-clock"></i> {{ $service->duration_mins }} Mins</div>
                            <div class="product-meta-item"><i class="fa-solid fa-shield-halved"></i> {{ $service->warranty_days }} days warranty</div>
                        </div>
                    </div>
                    </a>
                    <div class="product-card-body" style="padding-top:0;">
                        <button type="button" class="btn-book-now js-open-booking"
                            data-service-id="{{ $service->id }}"
                            data-service-name="{{ $service->displayTitle() }}"
                            data-service-price="₹{{ number_format($service->price_sale, 0) }}">BOOK NOW</button>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-wrapper alt-bg" id="amc-plans-section">
    <div class="container">
        <div class="amc-banner">
            <div>
                <div class="amc-title">{{ $site['amc_title'] }}</div>
                <p class="amc-desc">{{ $site['amc_description'] }}</p>
            </div>
            @if($amcWaUrl)
            <a class="btn btn-whatsapp" href="{{ $amcWaUrl }}" target="_blank" rel="noopener">
                <i class="fa-brands fa-whatsapp"></i> {{ $site['amc_button_text'] ?? 'Inquire AMC Plans' }}
            </a>
            @endif
        </div>
    </div>
</section>

<section class="section-wrapper">
    <div class="container">
        <div class="section-head-center">
            <h2>How It Works - 4 Easy Steps</h2>
            <p>{{ $site['steps_intro'] ?? 'Getting expert doorstep home repair & installation service is fast, transparent and hassle-free.' }}</p>
        </div>
        <div class="steps-4-grid">
            @foreach($steps as $step)
                <article class="steps-4-card">
                    <div class="steps-4-badge">STEP {{ $step->step_number }}</div>
                    <div class="steps-4-title">{{ $step->step_number }}. {{ $step->title }}</div>
                    <p class="steps-4-desc">{{ $step->description }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="section-wrapper alt-bg">
    <div class="container">
        <div class="section-head-center">
            <h2>Our Work Gallery &amp; Recent Projects</h2>
            <p>{{ $site['gallery_intro'] ?? 'Real photos of our certified technicians carrying out doorstep repair, chemical servicing, and installation jobs across Delhi NCR.' }}</p>
        </div>
        <div class="gallery-grid">
            @foreach($gallery as $item)
                <figure class="gallery-card">
                    @if($item->image && str_starts_with($item->image, 'assets/'))
                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" loading="lazy">
                    @elseif($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" loading="lazy">
                    @else
                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#fecaca,#fff1f2);"></div>
                    @endif
                    <figcaption class="gallery-overlay">
                        @if($item->subtitle)<div class="gallery-tag">{{ $item->subtitle }}</div>@endif
                        <div class="gallery-title">{{ $item->title }}</div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>

<section class="section-wrapper">
    <div class="container">
        <div class="section-head-center">
            <div class="section-kicker">Our Promise &amp; Quality Standards</div>
            <h2>Why Choose {{ $site['site_name'] ?? 'Us' }}</h2>
            <p>{{ $site['why_intro'] ?? ($site['region_label'] ?? 'Delhi NCR')."'s standard for fast, reliable, transparent home appliance repair and interior panel solutions." }}</p>
        </div>
        <div class="why-cards-grid">
            @foreach($features as $feature)
                <article class="why-card">
                    <div class="why-card-top">{{ $feature->icon }}</div>
                    <div class="why-card-title">{{ $feature->title }}</div>
                    <p class="why-card-desc">{{ $feature->description }}</p>
                    <div class="why-badges">
                        @if($feature->badge_one)<span>{{ $feature->badge_one }}</span>@endif
                        @if($feature->badge_two)<span>{{ $feature->badge_two }}</span>@endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="partner-network-section">
    <div class="container">
        <div class="section-head-center">
            <div class="section-kicker" style="color:#fecaca;">Our Technician Network</div>
            <h2>{{ $site['network_title'] }}</h2>
            <p>{{ $site['network_description'] }}</p>
        </div>
        <div class="stats-grid">
            @foreach($stats as $stat)
                <div class="stat-box">
                    <div class="val">{{ $stat->value }}{{ $stat->suffix }}</div>
                    <div class="lbl">{{ $stat->label }}</div>
                </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:24px;">
            <a href="{{ route('partners.join') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Join as Partner</a>
        </div>
    </div>
</section>

@include('partials.site-footer', [
    'services' => $services,
    'featuredServices' => $featuredServices,
    'cities' => $cities,
    'footerPages' => $footerPages,
])
@endsection
