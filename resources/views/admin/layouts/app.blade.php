<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | CMS</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <h1>RepairCares CMS</h1>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Bookings</a>
            <a href="{{ route('admin.technician-applications.index') }}" class="{{ request()->routeIs('admin.technician-applications.*') ? 'active' : '' }}">Technician Partners</a>
            <a href="{{ route('admin.service-categories.index') }}" class="{{ request()->routeIs('admin.service-categories.*') ? 'active' : '' }}">Service Categories</a>
            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">Services</a>
            <a href="{{ route('admin.cities.index') }}" class="{{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">Cities</a>
            <a href="{{ route('admin.gallery.index') }}" class="{{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('admin.hero-slides.index') }}" class="{{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">Hero Slides</a>
            <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">Pages</a>
            <a href="{{ route('admin.features.index') }}" class="{{ request()->routeIs('admin.features.*') ? 'active' : '' }}">Why Choose Us</a>
            <a href="{{ route('admin.steps.index') }}" class="{{ request()->routeIs('admin.steps.*') ? 'active' : '' }}">How It Works</a>
            <a href="{{ route('admin.stats.index') }}" class="{{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">Network Stats</a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Site Settings</a>
            <a href="{{ route('home') }}" target="_blank">View Website</a>
        </nav>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:1rem;">
            @csrf
            <button class="btn btn-secondary" type="submit">Logout</button>
        </form>
    </aside>
    <main class="admin-main">
        @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
        @if(isset($errors) && $errors->any())
            <div class="errors">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
