@extends('admin.layouts.app')
@section('title', $category->exists ? 'Edit Category' : 'Add Category')
@section('content')
@include('admin.partials.page-header', ['title' => $category->exists ? 'Edit category' : 'Add category'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $category->exists ? route('admin.service-categories.update', $category) : route('admin.service-categories.store') }}">
        @csrf
        @if($category->exists) @method('PUT') @endif
        <div class="form-row"><label>Name</label><input name="name" value="{{ old('name', $category->name) }}" required></div>
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"></div>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.service-categories.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
