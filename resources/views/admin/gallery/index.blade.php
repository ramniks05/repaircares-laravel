@extends('admin.layouts.app')
@section('title', 'Gallery')
@section('content')
@include('admin.partials.page-header', ['title' => 'Work gallery', 'action' => route('admin.gallery.create'), 'actionLabel' => 'Add item'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Sort</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>
                        @if($item->image && str_starts_with($item->image, 'assets/'))
                            <img class="thumb" src="{{ asset($item->image) }}" alt="">
                        @elseif($item->image)
                            <img class="thumb" src="{{ asset('storage/'.$item->image) }}" alt="">
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->subtitle ?? '—' }}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>@include('admin.partials.bool-badge', ['value' => $item->is_active])</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.gallery.edit', $item),
                            'deleteUrl' => route('admin.gallery.destroy', $item),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No gallery items.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
