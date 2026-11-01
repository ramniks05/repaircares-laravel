@extends('admin.layouts.app')
@section('title', 'Edit Site Settings')
@section('content')
@include('admin.partials.page-header', ['title' => 'Edit site settings'])

<div class="card admin-form-card">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf @method('PUT')
        @foreach($labels as $key => $label)
            <div class="form-row">
                <label>{{ $label }}</label>
                @if(in_array($key, ['services_intro','amc_description','network_description','footer_about','service_hours'], true))
                    <textarea name="{{ $key }}">{{ old($key, $settings[$key] ?? '') }}</textarea>
                @else
                    <input name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}">
                @endif
            </div>
        @endforeach
        <div class="admin-form-actions">
            <button class="btn" type="submit">Save settings</button>
            <a class="btn btn-secondary" href="{{ route('admin.settings.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
