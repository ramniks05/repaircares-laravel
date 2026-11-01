<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CityController as AdminCityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatController as AdminStatController;
use App\Http\Controllers\Admin\TechnicianApplicationController as AdminTechnicianApplicationController;
use App\Http\Controllers\Admin\WorkStepController as AdminWorkStepController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerRegistrationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServicePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/service/{slug}', [ServicePageController::class, 'show'])->name('services.show');
Route::get('/service.php', function () {
    $slug = request('slug');
    if (! is_string($slug) || $slug === '') {
        return redirect()->route('home');
    }

    return redirect()->route('services.show', $slug, 301);
});
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/join-technician', [PartnerRegistrationController::class, 'create'])->name('partners.join');
Route::post('/join-technician', [PartnerRegistrationController::class, 'store'])->name('partners.store');
Route::get('/join-technician.php', fn () => redirect()->route('partners.join', [], 301));

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::resource('service-categories', AdminServiceCategoryController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('bookings', AdminBookingController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('technician-applications', AdminTechnicianApplicationController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::resource('cities', AdminCityController::class)->except(['show']);
        Route::resource('gallery', AdminGalleryController::class)->except(['show']);
        Route::resource('hero-slides', AdminHeroSlideController::class)->except(['show']);
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::resource('features', AdminFeatureController::class)->except(['show']);
        Route::resource('steps', AdminWorkStepController::class)->except(['show']);
        Route::resource('stats', AdminStatController::class)->except(['show']);

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
