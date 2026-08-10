<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DeforestationRecordController;
use App\Http\Controllers\LandCoverTypeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MapLayerController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Route;

// Auth (guest only)
Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::login-page')->name('login');
    Route::livewire('/register', 'pages::register-page')->name('register');
});

// Logout
Route::post('/logout', function () {
    auth()->guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

// ===== Public =====
Route::view('/', 'landing')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/faq', 'faq')->name('faq');
Route::view('/teams', 'teams')->name('teams');
Route::get('/map', [MapController::class, 'show'])->name('map');
Route::livewire('/articles', 'pages::article-manager')->name('articles.index');
Route::livewire('/articles/{article:slug}', 'pages::article-show')->name('articles.show');

// ===== Admin (admin role only) =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard-page')->name('dashboard');
    Route::get('/regions', [RegionController::class, 'index'])->name('regions.index');
    Route::view('/regions/create', 'admin.regions-form', ['mode' => 'create'])->name('regions.create');
    Route::get('/regions/{region}/edit', [RegionController::class, 'edit'])->name('regions.edit');
    Route::delete('/regions/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');

    Route::get('/land-cover-types', [LandCoverTypeController::class, 'index'])->name('landCoverTypes.index');
    Route::view('/land-cover-types/create', 'admin.land-cover-types-form', ['mode' => 'create'])->name('landCoverTypes.create');
    Route::get('/land-cover-types/{landCoverType}/edit', [LandCoverTypeController::class, 'edit'])->name('landCoverTypes.edit');
    Route::delete('/land-cover-types/{landCoverType}', [LandCoverTypeController::class, 'destroy'])->name('landCoverTypes.destroy');

    Route::get('/deforestation-records', [DeforestationRecordController::class, 'index'])->name('deforestationRecords.index');
    Route::view('/deforestation-records/create', 'admin.deforestation-records-form', ['mode' => 'create'])->name('deforestationRecords.create');
    Route::get('/deforestation-records/{deforestationRecord}/edit', [DeforestationRecordController::class, 'edit'])->name('deforestationRecords.edit');
    Route::delete('/deforestation-records/{deforestationRecord}', [DeforestationRecordController::class, 'destroy'])->name('deforestationRecords.destroy');

    Route::get('/map-layers', [MapLayerController::class, 'index'])->name('mapLayers.index');
    Route::view('/map-layers/create', 'admin.map-layers-form', ['mode' => 'create'])->name('mapLayers.create');
    Route::get('/map-layers/{mapLayer}/edit', [MapLayerController::class, 'edit'])->name('mapLayers.edit');
    Route::delete('/map-layers/{mapLayer}', [MapLayerController::class, 'destroy'])->name('mapLayers.destroy');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::view('/articles/create', 'admin.articles-form', ['mode' => 'create'])->name('articles.create');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// ===== Editor (editor role) =====
Route::middleware(['auth', 'role:editor'])->prefix('editor')->name('editor.')->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard-page')->name('dashboard');
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::view('/articles/create', 'admin.articles-form', ['mode' => 'create'])->name('articles.create');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});
