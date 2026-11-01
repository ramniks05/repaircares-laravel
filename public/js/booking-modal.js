(function () {
    const modal = document.getElementById('quickBookingPopupModal');
    if (!modal) return;

    const summaryService = document.getElementById('modalSummaryService');
    const summaryPrice = document.getElementById('modalSummaryPrice');
    const summaryCity = document.getElementById('modalSummaryCity');
    const inputCity = document.getElementById('modal-booking-city');
    const inputService = document.getElementById('modal-booking-service-id');
    const defaultServiceLabel = summaryService?.textContent?.trim() || 'Home Repair Service';

    function openModal(options) {
        const opts = options || {};
        const serviceId = opts.serviceId ? String(opts.serviceId) : '';
        const serviceName = opts.serviceName || defaultServiceLabel;
        const priceText = opts.priceText || (serviceId ? '' : 'Best Rate');

        if (summaryService) summaryService.textContent = serviceName;
        if (summaryPrice) {
            summaryPrice.textContent = priceText || opts.fallbackPrice || 'Best Rate';
        }
        if (inputService) inputService.value = serviceId;

        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('booking-modal-open');

        const firstInput = modal.querySelector('input[name="customer_name"]');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    }

    function closeModal() {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('booking-modal-open');
    }

    window.openQuickBookingModal = openModal;
    window.closeQuickBookingModal = closeModal;

    window.handleHeaderBookClick = function (serviceName, itemTitle, priceText) {
        let name = serviceName || defaultServiceLabel;
        if (itemTitle && itemTitle !== serviceName) {
            name += ' - ' + itemTitle;
        }
        openModal({ serviceName: name, priceText: priceText || 'Best Rate' });
    };

    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
    });

    document.addEventListener('click', function (e) {
        const el = e.target.closest('.js-open-booking');
        if (!el) return;
        e.preventDefault();
        openModal({
            serviceId: el.getAttribute('data-service-id') || '',
            serviceName: el.getAttribute('data-service-name') || defaultServiceLabel,
            priceText: el.getAttribute('data-service-price') || 'Best Rate',
        });
    });

    window.syncBookingModalCity = function (cityId, cityName) {
        if (inputCity && cityId) inputCity.value = cityId;
        if (summaryCity && cityName) summaryCity.textContent = cityName;
    };

    if (document.body.dataset.openBookingModal === '1') {
        openModal({
            serviceId: document.body.dataset.bookingServiceId || '',
            serviceName: document.body.dataset.bookingServiceName || defaultServiceLabel,
            priceText: document.body.dataset.bookingServicePrice || 'Best Rate',
        });
    }

    if (window.location.hash === '#booking') {
        openModal({});
        history.replaceState(null, '', window.location.pathname + window.location.search);
    }
})();
