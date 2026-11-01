@extends('admin.layouts.app')
@section('title', 'Technician Partners')
@section('content')
@include('admin.partials.page-header', ['title' => 'Technician partner applications'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Applicant</th>
                <th>Email</th>
                <th>City</th>
                <th>Experience</th>
                <th>Skills</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $application)
                <tr>
                    <td>#{{ $application->id }}</td>
                    <td>{{ $application->full_name }}<br><small>{{ $application->phone }}</small></td>
                    <td>{{ $application->email }}</td>
                    <td>{{ $application->city?->name ?? '—' }}</td>
                    <td>{{ $application->work_experience }}</td>
                    <td><small>{{ \Illuminate\Support\Str::limit(implode(', ', $application->work_categories ?? []), 50) }}</small></td>
                    <td>{{ $application->status }}</td>
                    <td>{{ $application->created_at->format('d M Y') }}</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'viewUrl' => route('admin.technician-applications.show', $application),
                            'deleteUrl' => route('admin.technician-applications.destroy', $application),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="9">No applications yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $applications->links() }}
</div>
@endsection
