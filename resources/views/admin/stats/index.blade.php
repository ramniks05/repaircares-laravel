@extends('admin.layouts.app')
@section('title', 'Network Stats')
@section('content')
@include('admin.partials.page-header', ['title' => 'Network stats', 'action' => route('admin.stats.create'), 'actionLabel' => 'Add stat'])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Label</th>
                <th>Value</th>
                <th>Suffix</th>
                <th>Sort</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stats as $stat)
                <tr>
                    <td>{{ $stat->label }}</td>
                    <td><strong>{{ $stat->value }}</strong></td>
                    <td>{{ $stat->suffix ?? '—' }}</td>
                    <td>{{ $stat->sort_order }}</td>
                    <td>
                        @include('admin.partials.row-actions', [
                            'editUrl' => route('admin.stats.edit', $stat),
                            'deleteUrl' => route('admin.stats.destroy', $stat),
                        ])
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No stats.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
