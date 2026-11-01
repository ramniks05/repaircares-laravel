(function () {
    const container = document.getElementById('homepage-hero-slider');
    const dataEl = document.getElementById('hero-slides-data');
    const heroImg = document.getElementById('homepageHeroImg');
    const dotsContainer = document.getElementById('slideDotsContainer');
    if (!container || !dataEl || !heroImg) return;

    let slides;
    try {
        slides = JSON.parse(dataEl.textContent || '[]');
    } catch (e) {
        return;
    }
    if (!slides.length) return;

    let currentIndex = 0;
    let timer = null;
    let startX = 0;
    let startY = 0;
    let isDragging = false;

    const dots = container.querySelectorAll('[data-hero-dot]');

    function scrollDotIntoStrip(index) {
        if (!dotsContainer) return;
        const dot = dotsContainer.querySelector('[data-hero-dot="' + index + '"]');
        if (!dot) return;
        dotsContainer.scrollLeft =
            dot.offsetLeft - dotsContainer.clientWidth / 2 + dot.offsetWidth / 2;
    }

    function goTo(index) {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        currentIndex = index;

        const slide = slides[index];
        heroImg.src = slide.url;
        if (slide.alt) {
            heroImg.alt = slide.alt;
        }

        dots.forEach(function (dot) {
            const idx = parseInt(dot.getAttribute('data-hero-dot'), 10);
            dot.classList.toggle('active', idx === index);
        });
        scrollDotIntoStrip(index);
    }

    function next() {
        goTo(currentIndex + 1);
    }

    function prev() {
        goTo(currentIndex - 1);
    }

    function handleSwipe(diffX, diffY) {
        if (Math.abs(diffX) < 50) return;
        if (Math.abs(diffX) <= Math.abs(diffY)) return;
        if (diffX > 0) next();
        else prev();
    }

    function startAuto() {
        stopAuto();
        timer = setInterval(next, 4000);
    }

    function stopAuto() {
        if (timer) clearInterval(timer);
        timer = null;
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function (e) {
            e.preventDefault();
            goTo(parseInt(dot.getAttribute('data-hero-dot'), 10));
            startAuto();
        });
    });

    container.querySelector('[data-hero-prev]')?.addEventListener('click', function () {
        prev();
        startAuto();
    });
    container.querySelector('[data-hero-next]')?.addEventListener('click', function () {
        next();
        startAuto();
    });

    container.addEventListener('mouseenter', stopAuto);
    container.addEventListener('mouseleave', startAuto);

    container.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        stopAuto();
    }, { passive: true });

    container.addEventListener('touchend', function (e) {
        const diffX = startX - e.changedTouches[0].clientX;
        const diffY = startY - e.changedTouches[0].clientY;
        handleSwipe(diffX, diffY);
        startAuto();
    }, { passive: true });

    container.addEventListener('mousedown', function (e) {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        stopAuto();
    });
    window.addEventListener('mouseup', function (e) {
        if (!isDragging) return;
        isDragging = false;
        handleSwipe(startX - e.clientX, startY - e.clientY);
        startAuto();
    });

    startAuto();
})();
