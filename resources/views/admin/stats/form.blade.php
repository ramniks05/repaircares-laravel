@extends('admin.layouts.app')
@section('title', $stat->exists ? 'Edit Stat' : 'Add Stat')
@section('content')
@include('admin.partials.page-header', ['title' => $stat->exists ? 'Edit stat' : 'Add stat'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $stat->exists ? route('admin.stats.update', $stat) : route('admin.stats.store') }}">
        @csrf
        @if($stat->exists) @method('PUT') @endif
        <div class="form-row"><label>Label</label><input name="label" value="{{ old('label', $stat->label) }}" required></div>
        <div class="form-row"><label>Value</label><input name="value" value="{{ old('value', $stat->value) }}" required></div>
        <div class="form-row"><label>Suffix</label><input name="suffix" value="{{ old('suffix', $stat->suffix) }}" placeholder="+ or ★"></div>
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $stat->sort_order ?? 0) }}"></div>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.stats.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
