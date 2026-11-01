@php
    $bookingServices = $bookingServices ?? collect();
    $bookingTimeSlots = $bookingTimeSlots ?? collect();
    $defaultServiceLabel = $site['hero_subtitle'] ?? 'Home Repair Service';
@endphp

<div class="city-modal-overlay booking-modal-overlay" id="quickBookingPopupModal" aria-hidden="true">
    <div class="booking-modal-card" role="dialog" aria-labelledby="booking-modal-title">
        <button type="button" class="booking-modal-close" onclick="window.closeQuickBookingModal()" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="hero-badge booking-modal-kicker">
            <i class="fa-solid fa-bolt"></i> {{ $site['hero_title'] ?? 'Instant Doorstep Booking' }}
        </div>

        <div class="booking-modal-summary">
            <div>
                <div id="modalSummaryService" class="booking-modal-summary-title">{{ $defaultServiceLabel }}</div>
                <div class="booking-modal-summary-loc">
                    📍 Location: <strong id="modalSummaryCity">{{ $site['region_label'] ?? 'Delhi NCR' }}</strong>
                </div>
            </div>
            <div id="modalSummaryPrice" class="booking-modal-summary-price">Best Rate</div>
        </div>

        <form class="lead-booking-form" id="modal-booking-form" method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="from_modal" value="1">
            <input type="hidden" name="city_id" id="modal-booking-city" value="{{ old('city_id', ($cities ?? collect())->first()?->id) }}">
            <input type="hidden" name="service_id" id="modal-booking-service-id" value="{{ old('service_id') }}">

            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Your Full Name *</label>
                <input type="text" name="customer_name" class="form-control" placeholder="e.g. Rahul Sharma" value="{{ old('from_modal') ? old('customer_name') : '' }}" required>
                @if(old('from_modal')) @error('customer_name')<small class="field-error">{{ $message }}</small>@enderror @endif
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-phone"></i> Mobile / WhatsApp Number *</label>
                <input type="tel" name="phone" class="form-control" placeholder="e.g. 9876543210" value="{{ old('from_modal') ? old('phone') : '' }}" required>
                @if(old('from_modal')) @error('phone')<small class="field-error">{{ $message }}</small>@enderror @endif
            </div>
            <div class="form-row-2 booking-modal-datetime">
                <div class="form-group">
                    <label><i class="fa-solid fa-calendar-day"></i> Select Date *</label>
                    <input type="date" name="booking_date" class="form-control" value="{{ old('from_modal') ? old('booking_date', date('Y-m-d')) : date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    @if(old('from_modal')) @error('booking_date')<small class="field-error">{{ $message }}</small>@enderror @endif
                </div>
                <div class="form-group">
                    <label><i class="fa-solid fa-clock"></i> Preferred Time Slot *</label>
                    <select name="time_slot_id" class="form-control" required>
                        @foreach($bookingTimeSlots as $slot)
                            <option value="{{ $slot->id }}" @selected(old('from_modal') && old('time_slot_id') == $slot->id)>{{ $slot->label }}</option>
                        @endforeach
                    </select>
                    @if(old('from_modal')) @error('time_slot_id')<small class="field-error">{{ $message }}</small>@enderror @endif
                </div>
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-location-dot"></i> Address / Message Note</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Flat no, society, landmark...">{{ old('from_modal') ? old('address') : '' }}</textarea>
            </div>
            <button type="submit" class="btn btn-whatsapp btn-submit-booking booking-modal-submit">
                <i class="fa-brands fa-whatsapp"></i> Confirm &amp; Book via WhatsApp
            </button>
        </form>
    </div>
</div>
