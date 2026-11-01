@props(['services', 'timeSlots', 'cities', 'site', 'selectedServiceId' => null])

<div class="booking-panel" id="booking">
    <div class="booking-summary">
        <div>
            <h3>{{ $site['hero_subtitle'] ?? 'Home Repair Service' }}</h3>
            <div class="loc">📍 Location: <strong id="booking-city-label">{{ $site['region_label'] ?? 'Delhi NCR' }}</strong></div>
        </div>
        <div class="best-rate">Best Rate</div>
    </div>
    <form class="lead-booking-form" method="POST" action="{{ route('bookings.store') }}">
        @csrf
        <div class="form-group">
            <label><i class="fa-solid fa-user"></i> Your Full Name *</label>
            <input type="text" name="customer_name" class="form-control" placeholder="e.g. Rahul Sharma" value="{{ old('customer_name') }}" required>
            @error('customer_name')<small style="color:#dc2626;">{{ $message }}</small>@enderror
        </div>
        <div class="form-group">
            <label><i class="fa-solid fa-phone"></i> Mobile / WhatsApp Number *</label>
            <input type="tel" name="phone" class="form-control" placeholder="e.g. 9876543210" value="{{ old('phone') }}" required>
            @error('phone')<small style="color:#dc2626;">{{ $message }}</small>@enderror
        </div>
        <input type="hidden" name="city_id" id="booking-city" value="{{ old('city_id', $cities->first()?->id) }}">
        <div class="form-group">
            <label><i class="fa-solid fa-screwdriver-wrench"></i> Service</label>
            <select id="booking-service" name="service_id" class="form-control">
                <option value="">General enquiry</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" @selected(old('service_id', $selectedServiceId) == $service->id)>{{ $service->displayTitle() }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row-2">
            <div class="form-group">
                <label><i class="fa-solid fa-calendar-day"></i> Select Date *</label>
                <input type="date" name="booking_date" class="form-control" value="{{ old('booking_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                @error('booking_date')<small style="color:#dc2626;">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label><i class="fa-solid fa-clock"></i> Preferred Time Slot *</label>
                <select name="time_slot_id" class="form-control" required>
                    @foreach($timeSlots as $slot)
                        <option value="{{ $slot->id }}" @selected(old('time_slot_id') == $slot->id)>{{ $slot->label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label><i class="fa-solid fa-location-dot"></i> Address / Message Note</label>
            <textarea name="address" class="form-control" rows="3" placeholder="Flat no, society, landmark...">{{ old('address') }}</textarea>
        </div>
        <button type="submit" class="btn-submit-booking"><i class="fa-brands fa-whatsapp"></i> Confirm &amp; Book via WhatsApp</button>
    </form>
</div>
