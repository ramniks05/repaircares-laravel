<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'bookingCount' => Booking::query()->count(),
            'pendingBookings' => Booking::query()->where('status', 'pending')->count(),
            'serviceCount' => Service::query()->count(),
            'recentBookings' => Booking::query()->with(['city', 'service', 'timeSlot'])->latest()->limit(8)->get(),
        ]);
    }
}
