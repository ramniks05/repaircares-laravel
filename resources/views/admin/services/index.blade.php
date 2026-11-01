@extends('admin.layouts.app')
@section('title', 'Services')
@section('content')
@include('admin.partials.page-header', ['title' => 'Services', 'action' => route('admin.services.create'), 'actionLabel' => 'Add service'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Slug</th>
                <th>Price (sale)</th>
                <th>Rating</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>
                        @if($service->cardImageUrl())
                            <img class="thumb" src="{{ $service->cardImageUrl() }}" alt="" style="vertical-align:middle;margin-right:6px;">
                        @endif
                        {{ $service->name }}<br><span class="text-muted">{{ $service->category?->name }}</span>
                    </td>
                    <td><code>{{ $service->slug }}</code></td>
                    <td>₹{{ number_format($service->price_sale, 0) }} <span class="text-muted" style="text-decoration:line-through;">₹{{ number_format($service->price_original, 0) }}</span></td>
                    <td>{{ number_format($service->rating, 1) }}</td>
                    <td>@include('admin.partials.bool-badge', ['value' => $service->is_featured])</td>
                    <td>@include('admin.partials.bool-badge', ['value' => $service->is_active])</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.services.edit', $service),
                            'deleteUrl' => route('admin.services.destroy', $service),
                            'deleteConfirm' => 'Delete service '.$service->name.'?',
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="8">No services.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $services->links() }}
</div>
@endsection
