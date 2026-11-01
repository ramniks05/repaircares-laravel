@php
    $slides = ($heroSlides ?? collect())->filter(fn ($s) => $s->imageUrl());
    if ($slides->isEmpty() && ! empty($site['hero_banner'])) {
        $fallback = new \App\Models\HeroSlide([
            'image' => $site['hero_banner'],
            'alt_text' => 'Home services banner',
        ]);
        $slides = collect([$fallback]);
    }
    $first = $slides->first();
@endphp

@if($slides->isNotEmpty())
<section class="hero-slider-container" id="homepage-hero-slider" aria-label="Promotional banners">
    <img
        class="hero-slide-img"
        id="homepageHeroImg"
        src="{{ $first->imageUrl() }}"
        alt="{{ $first->alt_text ?? 'Home services banner' }}"
        width="1920"
        height="420"
        decoding="async"
        fetchpriority="high"
    >

    @if($slides->count() > 1)
        <button type="button" class="hero-nav-btn prev-btn" aria-label="Previous slide" data-hero-prev>
            <i class="fa-solid fa-chevron-left"></i>
        </button>
        <button type="button" class="hero-nav-btn next-btn" aria-label="Next slide" data-hero-next>
            <i class="fa-solid fa-chevron-right"></i>
        </button>

        <div class="slide-dots" id="slideDotsContainer">
            @foreach($slides as $index => $slide)
                <button
                    type="button"
                    class="slide-dot @if($index === 0) active @endif"
                    data-hero-dot="{{ $index }}"
                    aria-label="Go to slide {{ $index + 1 }}"
                ></button>
            @endforeach
        </div>
    @endif
</section>

@if($slides->count() > 1)
<script type="application/json" id="hero-slides-data">@json($slides->map(fn ($s) => ['url' => $s->imageUrl(), 'alt' => $s->alt_text])->values())</script>
@endif
@endif
