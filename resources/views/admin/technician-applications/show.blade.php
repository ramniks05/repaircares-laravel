@extends('admin.layouts.app')
@section('title', 'Application #'.$application->id)
@section('content')
@include('admin.partials.page-header', ['title' => 'Application #'.$application->id, 'action' => route('admin.technician-applications.index'), 'actionLabel' => 'Back to list'])
<div class="card admin-form-card">
    <p><strong>Name:</strong> {{ $application->full_name }}</p>
    <p><strong>Phone:</strong> {{ $application->phone }}</p>
    <p><strong>Email:</strong> {{ $application->email }}</p>
    <p><strong>City:</strong> {{ $application->city?->name }}</p>
    <p><strong>Address:</strong><br>{!! nl2br(e($application->address)) !!}</p>
    <p><strong>Experience:</strong> {{ $application->work_experience }}</p>
    <p><strong>Skills:</strong> {{ implode(', ', $application->work_categories ?? []) }}</p>
    <p><strong>Aadhaar:</strong> {{ $application->aadhar_number }}</p>
    <p><strong>PAN:</strong> {{ $application->pan_number }}</p>
    @if($application->profile_photo)
        <p><strong>Photo:</strong><br><a href="{{ $application->documentUrl($application->profile_photo) }}" target="_blank" rel="noopener">View profile photo</a></p>
    @endif
    @if($application->aadhar_document)
        <p><a href="{{ $application->documentUrl($application->aadhar_document) }}" target="_blank" rel="noopener">View Aadhaar document</a></p>
    @endif
    @if($application->pan_document)
        <p><a href="{{ $application->documentUrl($application->pan_document) }}" target="_blank" rel="noopener">View PAN document</a></p>
    @endif
    <form method="POST" action="{{ route('admin.technician-applications.update', $application) }}" style="margin-top:1rem;">
        @csrf @method('PUT')
        <div class="form-row">
            <label>Status</label>
            <select name="status">
                @foreach(['pending', 'reviewing', 'approved', 'rejected'] as $status)
                    <option value="{{ $status }}" @selected($application->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn" type="submit">Update status</button>
    </form>
    <form method="POST" action="{{ route('admin.technician-applications.destroy', $application) }}" style="margin-top:1rem;" onsubmit="return confirm('Delete this application?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger" type="submit">Delete</button>
    </form>
</div>
@endsection
