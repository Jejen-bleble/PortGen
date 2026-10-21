<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\SettingsController;

// 1. Welcome Page (Landing Page)
Route::get('/', function () {
    return view('portfolios.welcome');
});

// Google Authentication Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Authenticated Routes Flow

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/home', [PortfolioController::class, 'index'])->name('home');

    // Portfolio Creation Wizard
    Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios/details', [PortfolioController::class, 'storeDetails'])->name('portfolios.storeDetails');
    Route::get('/portfolios/choose-template', [PortfolioController::class, 'chooseTemplate'])->name('portfolios.chooseTemplate');
    
    // Template Preview in New Tab (using active session data)
    Route::get('/portfolios/preview-template/{template}', [PortfolioController::class, 'previewTemplate'])->name('portfolios.previewTemplate');

    Route::post('/portfolios/generate', [PortfolioController::class, 'generateFinal'])->name('portfolios.generate');

    // Portfolio Management: Edit & Update
    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::delete('/settings/delete', [SettingsController::class, 'destroy'])->name('settings.destroy');
});

// Public portfolio viewing route
Route::get('/p/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');

// REQUIRED: This registers the login, register, and logout routes!
require __DIR__.'/auth.php';