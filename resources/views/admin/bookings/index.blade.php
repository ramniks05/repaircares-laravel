@extends('admin.layouts.app')
@section('title', 'Bookings')
@section('content')
@include('admin.partials.page-header', ['title' => 'Customer bookings'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>City</th>
                <th>Service</th>
                <th>Schedule</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->customer_name }}<br><small>{{ $booking->phone }}</small></td>
                    <td>{{ $booking->city?->name ?? '—' }}</td>
                    <td>{{ $booking->service?->name ?? 'General' }}</td>
                    <td>{{ $booking->booking_date->format('d M Y') }}<br><small>{{ $booking->timeSlot?->label }}</small></td>
                    <td>{{ $booking->status }}</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'viewUrl' => route('admin.bookings.show', $booking),
                            'deleteUrl' => route('admin.bookings.destroy', $booking),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">No bookings yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $bookings->links() }}
</div>
@endsection
