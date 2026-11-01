@extends('layouts.public')

@section('title', 'Join as Technician Partner | '.($site['site_name'] ?? ''))

@section('meta_description', 'Register as a certified technician partner in '.($site['region_label'] ?? 'Delhi NCR').'. Get daily doorstep repair jobs for AC, RO, fridge, electrician, plumber & more.')

@section('content')
<section class="partner-page-hero">
    <div class="container">
        <div class="hero-badge partner-hero-badge"><i class="fa-solid fa-user-plus"></i> Technician partner program</div>
        <h1>Join as Technician Partner</h1>
        <p>Register with {{ $site['site_name'] ?? 'us' }} and get verified doorstep repair &amp; service jobs across {{ $site['region_label'] ?? 'Delhi NCR' }}.</p>
    </div>
</section>

<div class="container partner-form-wrap">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form class="partner-reg-form" method="POST" action="{{ route('partners.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="partner-form-section">
            <h3><i class="fa-solid fa-user-gear"></i> 1. Personal &amp; contact details</h3>
            <div class="partner-form-grid">
                <div class="form-group">
                    <label>Full name *</label>
                    <input type="text" name="full_name" class="form-control" required placeholder="Enter your full name" value="{{ old('full_name') }}">
                    @error('full_name')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>Mobile number *</label>
                    <input type="tel" name="phone" class="form-control" required pattern="[0-9]{10}" placeholder="10 digit phone" value="{{ old('phone') }}">
                    @error('phone')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>Gmail / email *</label>
                    <input type="email" name="email" class="form-control" required placeholder="yourname@gmail.com" value="{{ old('email') }}">
                    @error('email')<small class="field-error">{{ $message }}</small>@enderror
                </div>
            </div>
            <div class="form-group">
                <label>City in {{ $site['region_label'] ?? 'Delhi NCR' }} *</label>
                <select name="city_id" class="form-control" required>
                    <option value="">Select city</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" @selected(old('city_id') == $city->id)>{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')<small class="field-error">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label>Current address *</label>
                <textarea name="address" class="form-control" rows="2" required placeholder="House no., street, area, city">{{ old('address') }}</textarea>
                @error('address')<small class="field-error">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="partner-form-section">
            <h3><i class="fa-solid fa-camera"></i> 2. Profile photo *</h3>
            <div class="partner-photo-row">
                <div class="partner-photo-preview" id="partnerPhotoPreview">
                    <i class="fa-solid fa-user-large"></i>
                    <span>No photo selected</span>
                </div>
                <div class="partner-photo-actions">
                    <p>Upload a clear front-facing photo (or use camera on mobile).</p>
                    <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/*" capture="user" required>
                    @error('profile_photo')<small class="field-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="partner-form-section">
            <h3><i class="fa-solid fa-id-card"></i> 3. KYC documents</h3>
            <div class="partner-form-grid">
                <div class="form-group">
                    <label>Aadhaar number *</label>
                    <input type="text" name="aadhar_number" class="form-control" required value="{{ old('aadhar_number') }}" placeholder="12-digit Aadhaar">
                    @error('aadhar_number')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>Upload Aadhaar (PDF/JPG) *</label>
                    <input type="file" name="aadhar_document" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                    @error('aadhar_document')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>PAN number *</label>
                    <input type="text" name="pan_number" class="form-control" required value="{{ old('pan_number') }}" placeholder="ABCDE1234F">
                    @error('pan_number')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="form-group">
                    <label>Upload PAN (PDF/JPG) *</label>
                    <input type="file" name="pan_document" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                    @error('pan_document')<small class="field-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="partner-form-section">
            <h3><i class="fa-solid fa-screwdriver-wrench"></i> 4. Work experience &amp; skills</h3>
            <div class="form-group">
                <label>Total experience *</label>
                <select name="work_experience" class="form-control" required>
                    <option value="">Select experience years</option>
                    @foreach(['1 Year', '2 Years', '3 Years', '4 Years', '5 Years', '6–8 Years', '8–10 Years', '10+ Years'] as $exp)
                        <option value="{{ $exp }}" @selected(old('work_experience') === $exp)>{{ $exp }}</option>
                    @endforeach
                </select>
                @error('work_experience')<small class="field-error">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label>Work categories you can handle * (select all that apply)</label>
                <div class="partner-skill-grid">
                    @foreach($skillOptions as $skill)
                        <label class="partner-skill-chip">
                            <input type="checkbox" name="work_categories[]" value="{{ $skill }}" @checked(is_array(old('work_categories')) && in_array($skill, old('work_categories')))>
                            <span>{{ $skill }}</span>
                        </label>
                    @endforeach
                </div>
                @error('work_categories')<small class="field-error">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="partner-form-submit">
            <button type="submit" class="btn btn-primary partner-submit-btn">
                <i class="fa-solid fa-paper-plane"></i> Submit registration
            </button>
            <p class="partner-form-note">After submit you may be redirected to WhatsApp to confirm with our team. Documents are stored securely for verification.</p>
        </div>
    </form>
</div>

@include('partials.site-footer')

@push('scripts')
<script>
(function () {
    var input = document.getElementById('profilePhotoInput');
    var preview = document.getElementById('partnerPhotoPreview');
    if (!input || !preview) return;
    input.addEventListener('change', function () {
        var file = input.files && input.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
@endsection
