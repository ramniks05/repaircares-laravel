<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\City;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Support\SiteSettings;
use App\Support\WhatsAppLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BookingController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $fromModal = $request->boolean('from_modal');

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'city_id' => ['required', 'exists:cities,id'],
            'service_id' => ['nullable', 'exists:services,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot_id' => ['required', 'exists:time_slots,id'],
            'address' => ['nullable', 'string', 'max:2000'],
        ]);

        $booking = Booking::query()->create([
            ...$validated,
            'status' => 'pending',
        ]);

        $city = City::find($validated['city_id']);
        $service = isset($validated['service_id']) ? Service::find($validated['service_id']) : null;
        $slot = TimeSlot::find($validated['time_slot_id']);

        $waUrl = WhatsAppLink::url(
            WhatsAppLink::bookingRequestMessage($booking, $city, $service, $slot)
        );

        if ($waUrl) {
            return redirect()->away($waUrl);
        }

        if ($fromModal) {
            return redirect()->back()->with('success', 'Booking received! We will contact you shortly.');
        }

        return redirect()->to(URL::previous().'#booking')->with('success', 'Booking received! We will contact you shortly.');
    }
}
