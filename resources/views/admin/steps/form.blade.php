@extends('admin.layouts.app')
@section('title', $step->exists ? 'Edit Step' : 'Add Step')
@section('content')
@include('admin.partials.page-header', ['title' => $step->exists ? 'Edit step' : 'Add step'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $step->exists ? route('admin.steps.update', $step) : route('admin.steps.store') }}">
        @csrf
        @if($step->exists) @method('PUT') @endif
        <div class="form-row"><label>Step number</label><input type="number" name="step_number" min="1" value="{{ old('step_number', $step->step_number) }}" required></div>
        <div class="form-row"><label>Title</label><input name="title" value="{{ old('title', $step->title) }}" required></div>
        <div class="form-row"><label>Description</label><textarea name="description" rows="3" required>{{ old('description', $step->description) }}</textarea></div>
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $step->sort_order ?? 0) }}"></div>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.steps.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
