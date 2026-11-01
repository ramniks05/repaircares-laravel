@extends('admin.layouts.app')
@section('title', 'Why Choose Us')
@section('content')
@include('admin.partials.page-header', ['title' => 'Why choose us', 'action' => route('admin.features.create'), 'actionLabel' => 'Add card'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Icon</th>
                <th>Title</th>
                <th>Badges</th>
                <th>Sort</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($features as $feature)
                <tr>
                    <td>{{ $feature->icon }}</td>
                    <td>{{ $feature->title }}<br><span class="text-muted">{{ \Illuminate\Support\Str::limit($feature->description, 80) }}</span></td>
                    <td>{{ $feature->badge_one }} @if($feature->badge_two) · {{ $feature->badge_two }} @endif</td>
                    <td>{{ $feature->sort_order }}</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.features.edit', $feature),
                            'deleteUrl' => route('admin.features.destroy', $feature),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No feature cards.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
