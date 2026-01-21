<?php

use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Routes (Login, Password Reset, etc.)
    Route::middleware('guest')->group(function () {
        Route::get('login', \App\Livewire\Admin\Auth\Login::class)->name('login');
        Route::get('forgot-password', \App\Livewire\Admin\Auth\ForgotPassword::class)->name('password.request');
        Route::get('reset-password/{token}', \App\Livewire\Admin\Auth\ResetPassword::class)->name('password.reset');
    });

    // Two-Factor Verification (separate from other auth middleware)
    Route::middleware('auth')->group(function () {
        Route::get('two-factor/verify', \App\Livewire\Admin\Auth\TwoFactorVerify::class)->name('two-factor.verify');
        Route::get('two-factor/setup', \App\Livewire\Admin\Auth\TwoFactorSetup::class)->name('two-factor.setup');
    });

    // Logout
    Route::post('logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');

    // Protected Admin Routes
    Route::middleware(['auth', 'verified', 'admin', 'two-factor'])->group(function () {
        // Dashboard
        Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard.index');

        // Users Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Users\Index::class)->name('index');
            Route::get('create', \App\Livewire\Admin\Users\Create::class)->name('create');
            Route::get('{user}/edit', \App\Livewire\Admin\Users\Edit::class)->name('edit');
        });

        // Roles & Permissions
        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', \App\Livewire\Admin\Roles\Index::class)->name('index');
            Route::get('create', \App\Livewire\Admin\Roles\Create::class)->name('create');
            Route::get('{role}/edit', \App\Livewire\Admin\Roles\Edit::class)->name('edit');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('general', \App\Livewire\Admin\Settings\General::class)->name('general');
            Route::get('email', \App\Livewire\Admin\Settings\Email::class)->name('email');
            Route::get('security', \App\Livewire\Admin\Settings\Security::class)->name('security');
            Route::get('appearance', \App\Livewire\Admin\Settings\Appearance::class)->name('appearance');
        });

        // Site Settings
        Route::prefix('site-settings')->name('site-settings.')->group(function () {
            // Navbar Management
            Route::get('navbar', \App\Livewire\Admin\SiteSettings\Navbar\Index::class)->name('navbar.index');
            
            // Topbar Settings
            Route::get('topbar', \App\Livewire\Admin\SiteSettings\Topbar::class)->name('topbar');
        });

        // Homepage
        Route::prefix('homepage')->name('homepage.')->group(function () {
            // Hero Section
            Route::get('hero-section', \App\Livewire\Admin\Homepage\HeroSection::class)->name('hero-section');
            
            // About Us Section
            Route::get('about-us', \App\Livewire\Admin\Homepage\AboutUsSection::class)->name('about-us');
            
            // Testimonials
            Route::get('testimonials', \App\Livewire\Admin\Homepage\Testimonials::class)->name('testimonials');
            
            // Newsletter Section
            Route::get('newsletter-section', \App\Livewire\Admin\Homepage\NewsletterSection::class)->name('newsletter-section');
        });

        // Events
        Route::prefix('events')->name('events.')->group(function () {
            // Events Hero
            Route::get('hero', \App\Livewire\Admin\Events\EventsHero::class)->name('hero');
            // Manage Events
            Route::get('/', \App\Livewire\Admin\Events\EventsIndex::class)->name('index');
            Route::get('create', \App\Livewire\Admin\Events\EventForm::class)->name('create');
            Route::get('{eventId}/edit', \App\Livewire\Admin\Events\EventForm::class)->name('edit');
        });

        // Blog
        Route::prefix('blog')->name('blog.')->group(function () {
            // Blog Hero
            Route::get('hero', \App\Livewire\Admin\Blog\BlogHero::class)->name('hero');
            // Blog Posts
            Route::get('/', \App\Livewire\Admin\Blog\BlogPostsIndex::class)->name('index');
            Route::get('create', \App\Livewire\Admin\Blog\BlogPostForm::class)->name('create');
            Route::get('{id}/edit', \App\Livewire\Admin\Blog\BlogPostForm::class)->name('edit');
        });

        // Services
        Route::prefix('services')->name('services.')->group(function () {
            // Services Hero
            Route::get('hero', \App\Livewire\Admin\Services\ServicesHero::class)->name('hero');
            // Services Box
            Route::get('/', \App\Livewire\Admin\Services\ServicesIndex::class)->name('index');
            Route::get('create', \App\Livewire\Admin\Services\ServiceForm::class)->name('create');
            Route::get('{id}/edit', \App\Livewire\Admin\Services\ServiceForm::class)->name('edit');
        });

        // Volunteers
        Route::prefix('volunteers')->name('volunteers.')->group(function () {
            // Volunteers Hero
            Route::get('hero', \App\Livewire\Admin\Volunteers\VolunteersHero::class)->name('hero');
            // Volunteers List
            Route::get('/', \App\Livewire\Admin\Volunteers\VolunteersIndex::class)->name('index');
            Route::get('create', \App\Livewire\Admin\Volunteers\VolunteerForm::class)->name('create');
            Route::get('{id}/edit', \App\Livewire\Admin\Volunteers\VolunteerForm::class)->name('edit');
        });

        // FAQ
        Route::prefix('faq')->name('faq.')->group(function () {
            // FAQ Hero
            Route::get('hero', \App\Livewire\Admin\Faq\FaqHero::class)->name('hero');
            // FAQ Settings
            Route::get('settings', \App\Livewire\Admin\Faq\FaqSettings::class)->name('settings');
            // FAQ Categories
            Route::get('categories', \App\Livewire\Admin\Faq\FaqCategories::class)->name('categories');
            // FAQ Items
            Route::get('items', \App\Livewire\Admin\Faq\FaqItems::class)->name('items');
        });

        // Contact
        Route::prefix('contact')->name('contact.')->group(function () {
            // Contact Hero
            Route::get('hero', \App\Livewire\Admin\Contact\ContactHero::class)->name('hero');
            // Contact Settings
            Route::get('settings', \App\Livewire\Admin\Contact\ContactSettings::class)->name('settings');
            // Contact Messages
            Route::get('messages', \App\Livewire\Admin\Contact\ContactMessages::class)->name('messages');
        });

        // Donations
        Route::get('donations', \App\Livewire\Admin\Donations::class)->name('donations');

        // Subscribers
        Route::get('subscribers', \App\Livewire\Admin\Subscribers::class)->name('subscribers');
    });
});

// Frontend Routes
Route::get('/', [RoutingController::class, 'root'])->name('root');

// Events frontend
Route::get('/events/{slug}', \App\Livewire\Frontend\EventDetails::class)->name('events.show');

// Blog frontend
Route::get('/blog/{slug}', \App\Livewire\Frontend\BlogDetails::class)->name('blog.show');

// Services frontend
Route::get('/services', \App\Livewire\Frontend\ServicesPage::class)->name('services');

// Volunteers frontend
Route::get('/volunteers', \App\Livewire\Frontend\VolunteersPage::class)->name('volunteers');

// FAQ frontend
Route::get('/faq', \App\Livewire\Frontend\FaqPage::class)->name('faq');

// Contact frontend
Route::get('/contact', \App\Livewire\Frontend\ContactPage::class)->name('contact');

Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
Route::get('{any}', [RoutingController::class, 'firstLevel'])->name('any');
