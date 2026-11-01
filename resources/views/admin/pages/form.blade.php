@extends('admin.layouts.app')
@section('title', $page->exists ? 'Edit Page' : 'Add Page')
@section('content')
@include('admin.partials.page-header', ['title' => $page->exists ? 'Edit page' : 'Add page'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}">
        @csrf
        @if($page->exists) @method('PUT') @endif
        <div class="form-row"><label>Title</label><input name="title" value="{{ old('title', $page->title) }}" required></div>
        <div class="form-row"><label>Footer Section</label>
            <select name="footer_section">
                @foreach(['Quick Links','Appliance Repair','Home Maintenance','Interior & Decor'] as $section)
                    <option value="{{ $section }}" @selected(old('footer_section', $page->footer_section) === $section)>{{ $section }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row"><label>Content (HTML allowed)</label><textarea name="content" rows="10">{{ old('content', $page->content) }}</textarea></div>
        <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))> Published</label>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Cancel</a>
        </div>
    </form>
    @if($page->exists)
        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="margin-top:1rem;" onsubmit="return confirm('Delete page?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
    @endif
</div>
@endsection
