<?php

use App\Http\Controllers\Admin\ClickTrackingController;
use App\Http\Controllers\Admin\ContentCalendarController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProgrammaticPageController;
use App\Http\Controllers\Admin\SeoClusterController;
use App\Http\Controllers\Admin\SeoReportController;
use App\Http\Controllers\Admin\SeoTemplateController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProgrammaticPagePublicController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// ----------------------------------------------------------------
// Public Routes
// ----------------------------------------------------------------

Route::get('/', function () {
    $page = \App\Models\StaticPage::where('slug', 'home')->first();
    return view('pages.home', compact('page'));
})->name('home');

Route::get('/services', function () {
    $services = \App\Models\ServicePage::where('is_published', true)->get();
    return view('pages.services', compact('services'));
})->name('services.index');

Route::get('/services/{slug}', function ($slug) {
    $service = \App\Models\ServicePage::where('slug', $slug)->where('is_published', true)->firstOrFail();
    return view('pages.service_show', compact('service'));
})->name('services.show')->where('slug', '.*');

Route::get('/districts', function () {
    $districts = \App\Models\DistrictPage::where('is_published', true)->get();
    return view('pages.districts', compact('districts'));
})->name('districts.index');

Route::get('/districts/{slug}', function ($slug) {
    $district = \App\Models\DistrictPage::where('slug', $slug)->where('is_published', true)->firstOrFail();
    return view('pages.district_show', compact('district'));
})->name('districts.show');

Route::get('/faq', function () {
    $page = \App\Models\StaticPage::where('slug', 'faq')->first();
    return view('pages.faq', compact('page'));
})->name('faq');

Route::get('/contact', function () {
    $page = \App\Models\StaticPage::where('slug', 'contact')->first();
    return view('pages.contact', compact('page'));
})->name('contact');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Blog (public)
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});

// Programmatic Pages (public)
Route::get('/p/{slug}', [ProgrammaticPagePublicController::class, 'show'])->name('programmatic.show');

// ----------------------------------------------------------------
// Sitemap & Robots
// ----------------------------------------------------------------

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemaps/pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemaps/services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/sitemaps/districts.xml', [SitemapController::class, 'districts'])->name('sitemap.districts');
Route::get('/sitemaps/blog.xml', [SitemapController::class, 'blog'])->name('sitemap.blog');
Route::get('/sitemaps/programmatic.xml', [SitemapController::class, 'programmatic'])->name('sitemap.programmatic');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

// ----------------------------------------------------------------
// Admin Panel
// ----------------------------------------------------------------

Route::prefix('admin')->name('admin.')->group(function () {

    // Posts
    Route::resource('posts', PostController::class)->except(['show']);
    Route::post('posts/{post}/publish-now', [PostController::class, 'publishNow'])->name('posts.publish-now');
    Route::post('posts/{post}/schedule', [PostController::class, 'schedule'])->name('posts.schedule');
    Route::post('posts/{post}/duplicate', [PostController::class, 'duplicate'])->name('posts.duplicate');

    // Programmatic Pages
    Route::resource('programmatic', ProgrammaticPageController::class)->except(['show']);
    Route::post('programmatic/{programmaticPage}/publish', [ProgrammaticPageController::class, 'publish'])->name('programmatic.publish');
    Route::post('programmatic/{programmaticPage}/regenerate', [ProgrammaticPageController::class, 'regenerate'])->name('programmatic.regenerate');
    Route::post('programmatic/bulk-publish', [ProgrammaticPageController::class, 'bulkPublish'])->name('programmatic.bulk-publish');

    // SEO: Clusters
    Route::resource('seo/clusters', SeoClusterController::class)->names('seo.clusters');
    Route::post('seo/clusters/{cluster}/import-keywords', [SeoClusterController::class, 'importKeywords'])->name('seo.clusters.import-keywords');

    // SEO: Templates
    Route::resource('seo/templates', SeoTemplateController::class)->names('seo.templates');

    // SEO: Reports
    Route::get('seo/reports', [SeoReportController::class, 'index'])->name('seo.reports.index');

    // Content Calendar
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [ContentCalendarController::class, 'index'])->name('index');
        Route::post('/', [ContentCalendarController::class, 'store'])->name('store');
        Route::post('/bulk-schedule', [ContentCalendarController::class, 'bulkSchedule'])->name('bulk-schedule');
        Route::post('/{item}/publish-now', [ContentCalendarController::class, 'publishNow'])->name('publish-now');
        Route::post('/{item}/skip', [ContentCalendarController::class, 'skip'])->name('skip');
        Route::delete('/{item}', [ContentCalendarController::class, 'destroy'])->name('destroy');
    });

    // Click Tracking Dashboard
    Route::get('clicks', [\App\Http\Controllers\Admin\ClickStatsController::class, 'index'])->name('clicks.index');
});
