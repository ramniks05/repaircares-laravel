@extends('admin.layouts.app')
@section('title', 'Booking #'.$booking->id)
@section('content')
@include('admin.partials.page-header', ['title' => 'Booking #'.$booking->id, 'action' => route('admin.bookings.index'), 'actionLabel' => 'Back to list'])
<div class="card admin-form-card">
    <p><strong>Customer:</strong> {{ $booking->customer_name }}</p>
    <p><strong>Phone:</strong> {{ $booking->phone }}</p>
    <p><strong>City:</strong> {{ $booking->city?->name }}</p>
    <p><strong>Service:</strong> {{ $booking->service?->name ?? 'General enquiry' }}</p>
    <p><strong>Date:</strong> {{ $booking->booking_date->format('d M Y') }}</p>
    <p><strong>Time:</strong> {{ $booking->timeSlot?->label }}</p>
    <p><strong>Address:</strong><br>{!! nl2br(e($booking->address ?? '—')) !!}</p>
    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" style="margin-top:1rem;">
        @csrf @method('PUT')
        <div class="form-row"><label>Status</label>
            <select name="status">
                @foreach(['pending','confirmed','completed','cancelled'] as $status)
                    <option value="{{ $status }}" @selected($booking->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn" type="submit">Update Status</button>
    </form>
</div>
@endsection
