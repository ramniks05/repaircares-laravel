@extends('admin.layouts.app')
@section('title', 'Cities')
@section('content')
@include('admin.partials.page-header', ['title' => 'Service cities', 'action' => route('admin.cities.create'), 'actionLabel' => 'Add city'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Sort</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->name }}</td>
                    <td><code>{{ $city->slug }}</code></td>
                    <td>{{ $city->sort_order }}</td>
                    <td>@include('admin.partials.bool-badge', ['value' => $city->is_active])</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.cities.edit', $city),
                            'deleteUrl' => route('admin.cities.destroy', $city),
                            'deleteConfirm' => 'Delete city '.$city->name.'?',
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No cities yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
