@extends('admin.layouts.app')
@section('title', $service->exists ? 'Edit Service' : 'Add Service')
@section('content')
@include('admin.partials.page-header', ['title' => $service->exists ? 'Edit service' : 'Add service'])
<div class="card admin-form-card">
    <form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf
        @if($service->exists) @method('PUT') @endif
        <div class="form-row"><label>Category</label>
            <select name="service_category_id">
                <option value="">—</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('service_category_id', $service->service_category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row"><label>Name</label><input name="name" value="{{ old('name', $service->name) }}" required></div>
        <div class="form-row"><label>Short Description</label><textarea name="short_description">{{ old('short_description', $service->short_description) }}</textarea></div>
        <div class="form-row"><label>SEO Meta Description</label><textarea name="meta_description" rows="2">{{ old('meta_description', $service->meta_description) }}</textarea></div>
        <div class="form-row"><label>Service Page Content (HTML allowed)</label><textarea name="detail_content" rows="8">{{ old('detail_content', $service->detail_content) }}</textarea></div>
        <div class="form-row"><label>Listing image (subject / product — cards &amp; grids)</label><input name="listing_image" value="{{ old('listing_image', $service->listing_image) }}" placeholder="assets/images/repaircares-subject-electrician.jpg"></div>
        <div class="form-row"><label>Icon (emoji)</label><input name="icon" value="{{ old('icon', $service->icon) }}"></div>
        <div class="form-row"><label>Image</label><input type="file" name="image" accept="image/*">@if($service->image)<p><small>Current: {{ $service->image }}</small></p>@endif</div>
        <div class="form-row"><label>Original Price</label><input type="number" step="0.01" name="price_original" value="{{ old('price_original', $service->price_original) }}" required></div>
        <div class="form-row"><label>Sale Price</label><input type="number" step="0.01" name="price_sale" value="{{ old('price_sale', $service->price_sale) }}" required></div>
        <div class="form-row"><label>Rating</label><input type="number" step="0.1" min="0" max="5" name="rating" value="{{ old('rating', $service->rating ?? 4.8) }}" required></div>
        <div class="form-row"><label>Duration (mins)</label><input type="number" name="duration_mins" value="{{ old('duration_mins', $service->duration_mins ?? 45) }}" required></div>
        <div class="form-row"><label>Warranty (days)</label><input type="number" name="warranty_days" value="{{ old('warranty_days', $service->warranty_days ?? 30) }}" required></div>
        <div class="form-row"><label>Sort Order</label><input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}"></div>
        <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $service->is_featured))> Featured</label><br>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true))> Active</label>
        <div style="margin-top:1rem;display:flex;gap:.5rem;">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.services.index') }}">Cancel</a>
        </div>
    </form>
    @if($service->exists)
        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" style="margin-top:1rem;" onsubmit="return confirm('Delete this service?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
    @endif
</div>
@endsection
