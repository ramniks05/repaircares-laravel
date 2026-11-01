<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Service;
use App\Models\TechnicianApplication;
use App\Support\SiteSettings;
use App\Support\WhatsAppLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerRegistrationController extends Controller
{
    public function create(): View
    {
        return view('partners.join', [
            'site' => SiteSettings::all(),
            'cities' => City::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'skillOptions' => Service::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Service $s) => $s->displayTitle())
                ->unique()
                ->values(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'email' => ['required', 'email', 'max:255'],
            'city_id' => ['required', 'exists:cities,id'],
            'address' => ['required', 'string', 'max:2000'],
            'profile_photo' => ['required', 'image', 'max:4096'],
            'aadhar_number' => ['required', 'string', 'max:20'],
            'aadhar_document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'pan_number' => ['required', 'string', 'max:20'],
            'pan_document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'work_experience' => ['required', 'string', 'max:50'],
            'work_categories' => ['required', 'array', 'min:1'],
            'work_categories.*' => ['string', 'max:255'],
        ]);

        $application = TechnicianApplication::query()->create([
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'city_id' => $validated['city_id'],
            'address' => $validated['address'],
            'profile_photo' => $request->file('profile_photo')->store('technician-applications/photos', 'public'),
            'aadhar_number' => $validated['aadhar_number'],
            'aadhar_document' => $request->file('aadhar_document')->store('technician-applications/kyc', 'public'),
            'pan_number' => $validated['pan_number'],
            'pan_document' => $request->file('pan_document')->store('technician-applications/kyc', 'public'),
            'work_experience' => $validated['work_experience'],
            'work_categories' => $validated['work_categories'],
            'status' => 'pending',
        ]);

        $application->load('city');

        $waUrl = WhatsAppLink::url(WhatsAppLink::technicianApplicationMessage($application));

        if ($waUrl) {
            return redirect()->away($waUrl);
        }

        return redirect()
            ->route('partners.join')
            ->with('success', 'Application submitted! Application ID #'.$application->id.'. Our team will contact you soon.');
    }
}
