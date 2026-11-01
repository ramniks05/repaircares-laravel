@php
    $whatsappChatUrl = $whatsappChatUrl ?? \App\Support\WhatsAppLink::url(\App\Support\WhatsAppLink::chatMessage());
    $footerAppliance = ($footerServices ?? $services)->whereIn('slug', ['ac-repair','refrigerator','washing-machine','geyser-repair','dishwasher','microwave-oven','led-tv-repair']);
    $footerHome = ($footerServices ?? $services)->whereIn('slug', ['gas-stove','kitchen-chimney','cook-range','ro-water-purifier','electrician','carpenter','plumber']);
    $footerInterior = ($footerServices ?? $services)->whereIn('slug', ['sofa-wash-repair','wall-louver-panel','customized-wallpaper','aluminium-glass','interior-designer','painter']);
    $footerPopular = ($featuredServices ?? collect())->take(10);
    if ($footerPopular->isEmpty() && isset($footerServices)) {
        $footerPopular = $footerServices->where('is_featured', true)->take(10);
    }
    $amcUrl = route('home').'#amc-plans-section';
@endphp

<footer class="site-footer">
    <div class="footer-cta-band">
        <div class="container footer-cta-inner">
            <div class="footer-cta-copy">
                <h3>Need a technician at your doorstep?</h3>
                <p>Book AC, fridge, RO, geyser, chimney, electrician, plumber &amp; more — same-day service across {{ $site['region_label'] ?? 'Delhi NCR' }}.</p>
            </div>
            <div class="footer-cta-actions">
                <button type="button" class="footer-btn footer-btn-white js-open-booking"><i class="fa-solid fa-calendar-check"></i> Book a Service</button>
                <a href="tel:{{ preg_replace('/\s+/', '', $site['helpline'] ?? '') }}" class="footer-btn footer-btn-outline"><i class="fa-solid fa-phone"></i> Call Now</a>
                @if($whatsappChatUrl)
                    <a href="{{ $whatsappChatUrl }}" class="footer-btn footer-btn-wa" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                @endif
            </div>
        </div>
    </div>

    <div class="footer-main">
        <div class="container">
            <div class="footer-top-grid">
                <div class="footer-brand-block">
                    <div class="footer-brand-meta">
                        @php
                            $footerLogo = $site['logo_path'] ?? 'assets/images/repair-care-logo.jpg';
                            $brandName = $site['site_name'] ?? 'Repair Cares';
                        @endphp
                        <div class="footer-brand-row">
                            <img src="{{ asset($footerLogo) }}" alt="" class="logo-img logo-img--footer-mark" width="120" height="52" decoding="async">
                            <span class="logo-wordmark logo-wordmark--footer">{{ $brandName }}</span>
                        </div>
                        <p class="footer-about">{{ $site['footer_about'] }}</p>
                        <div class="footer-cities">
                            <span class="label">We serve:</span>
                            @foreach($footerCities ?? $cities ?? [] as $city)
                                <span class="footer-city-tag">{{ $city->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="footer-contact-cards">
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <div>
                                <strong>Service location</strong>
                                <span>{{ $site['head_offices'] }}</span>
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-phone"></i>
                            <div>
                                <strong>Phone</strong>
                                <a href="tel:{{ preg_replace('/\s+/', '', $site['helpline'] ?? '') }}">{{ $site['helpline'] }}</a>
                            </div>
                        </div>
                        @if(! empty($site['contact_email']))
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <a href="mailto:{{ $site['contact_email'] }}">{{ $site['contact_email'] }}</a>
                            </div>
                        </div>
                        @endif
                        @if(! empty($site['service_hours']))
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <strong>Service hours</strong>
                                <span>{{ $site['service_hours'] }}</span>
                            </div>
                        </div>
                        @endif
                        <div class="footer-contact-item">
                            <i class="fa-solid fa-shield-halved"></i>
                            <div>
                                <strong>AMC &amp; Priority Support</strong>
                                <a href="{{ $amcUrl }}">View annual maintenance plans</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title"><i class="fa-solid fa-snowflake"></i> Appliance Repair</h4>
                    <ul class="footer-links">
                        @foreach($footerAppliance as $service)
                            <li><a href="{{ route('services.show', $service->slug) }}">{{ $service->displayTitle() }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title"><i class="fa-solid fa-house-chimney"></i> Home Maintenance</h4>
                    <ul class="footer-links">
                        @foreach($footerHome as $service)
                            <li><a href="{{ route('services.show', $service->slug) }}">{{ $service->displayTitle() }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title"><i class="fa-solid fa-paint-roller"></i> Interior &amp; Decor</h4>
                    <ul class="footer-links">
                        @foreach($footerInterior as $service)
                            <li><a href="{{ route('services.show', $service->slug) }}">{{ $service->name }}</a></li>
                        @endforeach
                        <li><a href="{{ route('partners.join') }}">Join as Technician Partner</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title"><i class="fa-solid fa-link"></i> Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}#featured">Most booked services</a></li>
                        <li><a href="{{ $amcUrl }}">AMC plans</a></li>
                        @foreach(($footerPages ?? collect())->where('footer_section', 'Quick Links') as $page)
                            <li><a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="footer-services-strip">
                <h4><i class="fa-solid fa-fire"></i> Popular doorstep services</h4>
                <div class="footer-service-chips">
                    @foreach($footerPopular as $service)
                        <a href="{{ route('services.show', $service->slug) }}" class="footer-service-chip" title="View {{ $service->displayTitle() }}">
                            <i class="fa-solid fa-wrench"></i> {{ $service->name }}
                        </a>
                    @endforeach
                    <button type="button" class="footer-service-chip js-open-booking"><i class="fa-solid fa-plus"></i> Quick book</button>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p class="footer-copy">
                © {{ date('Y') }} <strong>{{ $site['site_name'] ?? '' }}</strong>. All rights reserved.
                <span class="footer-copy-sub">Serving {{ $site['region_label'] ?? 'Delhi NCR' }}</span>
            </p>
            <nav class="footer-legal-inline" aria-label="Legal">
                @foreach(($footerPages ?? collect())->where('footer_section', 'Quick Links') as $page)
                    @if(!$loop->first)<span class="sep" aria-hidden="true">|</span>@endif
                    <a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a>
                @endforeach
            </nav>
        </div>
    </div>
</footer>
