@extends('admin.layouts.app')
@section('title', $item->exists ? 'Edit Gallery' : 'Add Gallery')
@section('content')
@include('admin.partials.page-header', ['title' => $item->exists ? 'Edit gallery item' : 'Add gallery item'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $item->exists ? route('admin.gallery.update', $item) : route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="form-row"><label>Title</label><input name="title" value="{{ old('title', $item->title) }}" required></div>
        <div class="form-row"><label>Subtitle</label><input name="subtitle" value="{{ old('subtitle', $item->subtitle) }}"></div>
        <div class="form-row"><label>Image upload</label><input type="file" name="image" accept="image/*" @if(!$item->exists) required @endif></div>
        @if($item->image)
            <p class="text-muted">Current: {{ $item->image }}</p>
        @endif
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order ?? 0) }}"></div>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Active</label>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.gallery.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
