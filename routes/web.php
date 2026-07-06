<?php

// Маршрути сайту: лише публічна частина.
// Адмін-панель тепер на Filament — реєструється автоматично через AdminPanelProvider
// (доступна на /admin, окремих маршрутів тут не потрібно).
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ua', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');
