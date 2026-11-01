@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@include('admin.partials.page-header', ['title' => 'Dashboard'])
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin:1rem 0;">
    <div class="card"><strong>Total Bookings</strong><div style="font-size:1.8rem;">{{ $bookingCount }}</div></div>
    <div class="card"><strong>Pending</strong><div style="font-size:1.8rem;">{{ $pendingBookings }}</div></div>
    <div class="card"><strong>Services</strong><div style="font-size:1.8rem;">{{ $serviceCount }}</div></div>
</div>

<div class="card table-wrap">
    <h3 style="margin-top:0;">Recent bookings</h3>
    <table class="table">
        <thead><tr><th>ID</th><th>Customer</th><th>Service</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($recentBookings as $booking)
            <tr>
                <td><a href="{{ route('admin.bookings.show', $booking) }}">#{{ $booking->id }}</a></td>
                <td>{{ $booking->customer_name }}<br><small>{{ $booking->phone }}</small></td>
                <td>{{ $booking->service?->name ?? 'General' }}</td>
                <td>{{ $booking->booking_date->format('d M Y') }}<br><small>{{ $booking->timeSlot?->label }}</small></td>
                <td>{{ $booking->status }}</td>
            </tr>
        @empty
            <tr><td colspan="5">No bookings yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
