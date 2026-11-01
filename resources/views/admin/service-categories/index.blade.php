@extends('admin.layouts.app')
@section('title', 'Service Categories')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Service categories',
    'action' => route('admin.service-categories.create'),
])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Sort</th>
                <th>Services</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td><code class="text-muted">{{ $category->slug }}</code></td>
                    <td>{{ $category->sort_order }}</td>
                    <td>{{ $category->services_count }}</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.service-categories.edit', $category),
                            'deleteUrl' => route('admin.service-categories.destroy', $category),
                            'deleteConfirm' => 'Delete this category?',
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
