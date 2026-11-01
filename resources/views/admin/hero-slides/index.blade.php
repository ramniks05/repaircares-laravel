@extends('admin.layouts.app')
@section('title', 'Hero Slides')
@section('content')
@include('admin.partials.page-header', ['title' => 'Homepage banner slides', 'action' => route('admin.hero-slides.create'), 'actionLabel' => 'Add slide'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Preview</th>
                <th>Image path</th>
                <th>Alt text</th>
                <th>Sort</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($slides as $slide)
                <tr>
                    <td>
                        @if($slide->imageUrl())
                            <img class="thumb" src="{{ $slide->imageUrl() }}" alt="">
                        @else
                            —
                        @endif
                    </td>
                    <td><code>{{ $slide->image }}</code></td>
                    <td>{{ $slide->alt_text ?? '—' }}</td>
                    <td>{{ $slide->sort_order }}</td>
                    <td>@include('admin.partials.bool-badge', ['value' => $slide->is_active])</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.hero-slides.edit', $slide),
                            'deleteUrl' => route('admin.hero-slides.destroy', $slide),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No slides.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
