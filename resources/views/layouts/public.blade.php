<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', ($site['site_name'] ?? 'Home Services').' | '.($site['region_label'] ?? 'Delhi NCR'))</title>
    <meta name="description" content="@yield('meta_description', $site['site_tagline'] ?? 'Expert home appliance repair in Delhi NCR')">
    @stack('head')
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=23">
    <link rel="icon" href="{{ asset($site['logo_path'] ?? 'assets/images/repair-care-logo.jpg') }}" type="image/jpeg">
</head>
@php
    $reopenBookingModal = old('from_modal') || session('open_booking_modal');
    $reopenService = $reopenBookingModal && old('service_id')
        ? ($bookingServices ?? collect())->firstWhere('id', (int) old('service_id'))
        : null;
@endphp
<body
    @if($reopenBookingModal) data-open-booking-modal="1" @endif
    @if($reopenService)
        data-booking-service-id="{{ $reopenService->id }}"
        data-booking-service-name="{{ $reopenService->displayTitle() }}"
        data-booking-service-price="₹{{ number_format($reopenService->price_sale, 0) }}"
    @elseif($reopenBookingModal)
        data-booking-service-name="{{ $site['hero_subtitle'] ?? 'Home Repair Service' }}"
        data-booking-service-price="Best Rate"
    @endif
>
    <nav class="sahil-navbar">
        <div class="container nav-container">
            @php
                $logoPath = $site['logo_path'] ?? 'assets/images/repair-care-logo.jpg';
                $brandName = $site['site_name'] ?? 'Repair Cares';
            @endphp
            <a href="{{ route('home') }}" class="logo-brand" aria-label="{{ $brandName }}">
                <img src="{{ asset($logoPath) }}" alt="" class="logo-img" width="120" height="46" decoding="async">
                <span class="logo-wordmark">{{ $brandName }}</span>
            </a>
            <div class="nav-right-tools nav-desktop-only">
                <a href="{{ route('home') }}#featured" class="location-combobox nav-amc-link nav-services-link">
                    <i class="fa-solid fa-list"></i> Services
                </a>
                <a href="{{ route('home') }}#amc-plans-section" class="location-combobox nav-amc-link">
                    <i class="fa-solid fa-shield-halved"></i> AMC Plans
                </a>
                <a href="tel:{{ preg_replace('/\s+/', '', $site['helpline'] ?? '') }}" class="location-combobox nav-call-link" aria-label="Call helpline">
                    <i class="fa-solid fa-phone"></i> <span class="nav-call-text">{{ $site['helpline'] ?? 'Call' }}</span>
                </a>
                <div class="location-combobox nav-location-pill" role="button" tabindex="0" aria-label="Change city" onclick="document.getElementById('location-modal').classList.add('open')">
                    <i class="fa-solid fa-map-pin"></i>
                    <span id="selected-city-label" class="nav-location-label">{{ $site['region_label'] ?? 'Delhi NCR' }}</span>
                </div>
                <button type="button" class="btn-login js-open-booking"><i class="fa-brands fa-whatsapp"></i><span class="nav-book-label"> Book</span></button>
            </div>
            <div class="nav-mobile-actions" aria-label="Quick actions">
                <a href="tel:{{ preg_replace('/\s+/', '', $site['helpline'] ?? '') }}" class="nav-mobile-icon-btn" aria-label="Call">
                    <i class="fa-solid fa-phone"></i>
                </a>
                <button type="button" class="nav-mobile-icon-btn" aria-label="Change city" onclick="document.getElementById('location-modal').classList.add('open')">
                    <i class="fa-solid fa-map-pin"></i>
                </button>
                <button type="button" class="btn-login btn-login-mobile js-open-booking">
                    <i class="fa-brands fa-whatsapp"></i> Book
                </button>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container"><div class="alert-success">{{ session('success') }}</div></div>
    @endif
    @if($errors->any() && ! old('from_modal'))
        @push('scripts')
            <script>
                (function () {
                    var el = document.getElementById('booking');
                    if (el && el.classList.contains('booking-panel')) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else if (window.openQuickBookingModal) {
                        window.openQuickBookingModal();
                    }
                })();
            </script>
        @endpush
    @endif

    @yield('content')

    <div class="mobile-action-bar mobile-only-bar">
        <button type="button" class="primary js-open-booking" style="border:none;font:inherit;"><i class="fa-solid fa-calendar-check"></i> Book</button>
        <a href="tel:{{ preg_replace('/\s+/', '', $site['helpline'] ?? '') }}"><i class="fa-solid fa-phone"></i> Call Now</a>
        @if($whatsappChatUrl ?? null)
            <a href="{{ $whatsappChatUrl }}" class="wa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
        @endif
    </div>

    @if($whatsappChatUrl ?? null)
        <a href="{{ $whatsappChatUrl }}" class="wa-float-btn" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
            <span>WhatsApp</span>
        </a>
    @endif

    <div class="city-modal-overlay" id="location-modal" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="city-modal-card">
            <div class="city-modal-badge"><i class="fa-solid fa-location-dot"></i> {{ $site['region_label'] ?? 'Delhi NCR' }}</div>
            <h3>Select Your Location</h3>
            <p style="color:var(--muted);font-size:14px;margin-top:8px;">Choose your city to enter website and view local rates &amp; technician availability</p>
            <div class="city-pills" id="city-pills">
                @foreach(($cities ?? collect()) as $city)
                    <button type="button" data-city-id="{{ $city->id }}" data-city-name="{{ $city->name }}">{{ $city->name }}</button>
                @endforeach
            </div>
            <div style="margin-top:18px;">
                <button class="btn btn-primary" type="button" onclick="document.getElementById('location-modal').classList.remove('open')">Continue</button>
            </div>
        </div>
    </div>

    @include('partials.booking-modal')

    <script src="{{ asset('js/booking-modal.js') }}?v=3"></script>
    <script>
        (function () {
            const storageKey = 'selected_city';
            const label = document.getElementById('selected-city-label');
            const citySelect = document.getElementById('booking-city');
            const bookingCityLabel = document.getElementById('booking-city-label');
            const pills = document.querySelectorAll('#city-pills button');

            function applyCity(id, name) {
                localStorage.setItem(storageKey, JSON.stringify({ id, name }));
                if (label) label.textContent = name;
                if (bookingCityLabel) bookingCityLabel.textContent = name;
                if (citySelect) citySelect.value = id;
                if (window.syncBookingModalCity) window.syncBookingModalCity(id, name);
                pills.forEach(btn => btn.classList.toggle('active', btn.dataset.cityId === String(id)));
            }

            const saved = localStorage.getItem(storageKey);
            if (saved) {
                try { applyCity(JSON.parse(saved).id, JSON.parse(saved).name); } catch (e) {}
            } else if (pills.length) {
                applyCity(pills[0].dataset.cityId, pills[0].dataset.cityName);
            }

            pills.forEach(btn => btn.addEventListener('click', () => applyCity(btn.dataset.cityId, btn.dataset.cityName)));

            if (!localStorage.getItem('city_modal_seen') && window.matchMedia('(min-width: 992px)').matches) {
                document.getElementById('location-modal')?.classList.add('open');
                localStorage.setItem('city_modal_seen', '1');
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
