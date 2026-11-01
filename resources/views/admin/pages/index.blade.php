@extends('admin.layouts.app')
@section('title', 'Pages')
@section('content')
@include('admin.partials.page-header', ['title' => 'CMS pages', 'action' => route('admin.pages.create'), 'actionLabel' => 'Add page'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Footer section</th>
                <th>Published</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td><code>{{ $page->slug }}</code></td>
                    <td>{{ $page->footer_section ?? '—' }}</td>
                    <td>@include('admin.partials.bool-badge', ['value' => $page->is_published])</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.pages.edit', $page),
                            'deleteUrl' => route('admin.pages.destroy', $page),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No pages.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
