@extends('admin.layouts.app')
@section('title', $feature->exists ? 'Edit Feature' : 'Add Feature')
@section('content')
@include('admin.partials.page-header', ['title' => $feature->exists ? 'Edit feature card' : 'Add feature card'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $feature->exists ? route('admin.features.update', $feature) : route('admin.features.store') }}">
        @csrf
        @if($feature->exists) @method('PUT') @endif
        <div class="form-row"><label>Title</label><input name="title" value="{{ old('title', $feature->title) }}" required></div>
        <div class="form-row"><label>Description</label><textarea name="description" rows="4" required>{{ old('description', $feature->description) }}</textarea></div>
        <div class="form-row"><label>Badge 1</label><input name="badge_one" value="{{ old('badge_one', $feature->badge_one) }}"></div>
        <div class="form-row"><label>Badge 2</label><input name="badge_two" value="{{ old('badge_two', $feature->badge_two) }}"></div>
        <div class="form-row"><label>Icon (emoji)</label><input name="icon" value="{{ old('icon', $feature->icon) }}"></div>
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $feature->sort_order ?? 0) }}"></div>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.features.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
