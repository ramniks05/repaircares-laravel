@extends('admin.layouts.app')
@section('title', 'How It Works')
@section('content')
@include('admin.partials.page-header', ['title' => 'How it works steps', 'action' => route('admin.steps.create'), 'actionLabel' => 'Add step'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Step #</th>
                <th>Title</th>
                <th>Description</th>
                <th>Sort</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($steps as $step)
                <tr>
                    <td>{{ $step->step_number }}</td>
                    <td>{{ $step->title }}</td>
                    <td class="text-muted">{{ \Illuminate\Support\Str::limit($step->description, 90) }}</td>
                    <td>{{ $step->sort_order }}</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.steps.edit', $step),
                            'deleteUrl' => route('admin.steps.destroy', $step),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No steps.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
