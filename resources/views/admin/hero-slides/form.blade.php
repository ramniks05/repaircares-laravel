@extends('admin.layouts.app')
@section('title', $slide->exists ? 'Edit Slide' : 'Add Slide')
@section('content')
@include('admin.partials.page-header', ['title' => $slide->exists ? 'Edit hero slide' : 'Add hero slide'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}" enctype="multipart/form-data">
        @csrf
        @if($slide->exists) @method('PUT') @endif
        <div class="form-row"><label>Upload image</label><input type="file" name="image" accept="image/*"></div>
        <div class="form-row"><label>Or assets path</label><input name="image_path" value="{{ old('image_path', $slide->image) }}" placeholder="assets/images/hero_banner1.png"></div>
        <div class="form-row"><label>Alt text</label><input name="alt_text" value="{{ old('alt_text', $slide->alt_text) }}"></div>
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order ?? 0) }}"></div>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active ?? true))> Active</label>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.hero-slides.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
