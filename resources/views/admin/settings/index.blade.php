@extends('admin.layouts.app')
@section('title', 'Site Settings')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Site settings',
    'action' => route('admin.settings.edit'),
    'actionLabel' => 'Edit all',
])

<div class="card table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Setting</th>
                <th>Key</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    <td><code class="text-muted">{{ $row['key'] }}</code></td>
                    <td>{{ \Illuminate\Support\Str::limit($row['value'], 120) ?: '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<p class="text-muted">Site settings are updated in bulk. Use <strong>Edit all</strong> to change values.</p>
@endsection
