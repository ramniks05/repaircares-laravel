@extends('admin.layouts.app')
@section('title', $city->exists ? 'Edit City' : 'Add City')
@section('content')
@include('admin.partials.page-header', ['title' => $city->exists ? 'Edit city' : 'Add city'])

<div class="card admin-form-card">
    <form method="POST" action="{{ $city->exists ? route('admin.cities.update', $city) : route('admin.cities.store') }}">
        @csrf
        @if($city->exists) @method('PUT') @endif
        <div class="form-row"><label>Name</label><input name="name" value="{{ old('name', $city->name) }}" required></div>
        <div class="form-row"><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $city->sort_order ?? 0) }}"></div>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $city->is_active ?? true))> Active</label>
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save</button>
            <a class="btn btn-secondary" href="{{ route('admin.cities.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
