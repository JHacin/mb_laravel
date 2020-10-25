<?php

use Illuminate\Support\Facades\Route;

// Publicly visible pages
Route::get('/', [App\Http\Controllers\PagesController::class, 'index'])->name('home');
Route::get('/muce', [App\Http\Controllers\PagesController::class, 'catList'])->name('cat_list');
Route::get('/muce/{cat}', [App\Http\Controllers\PagesController::class, 'catDetails'])->name('cat_details');
Route::get('/muce/{cat}/postani-boter', [App\Http\Controllers\PagesController::class, 'becomeCatSponsor'])->name('become_cat_sponsor');

// User pages
Route::get('/profil', [App\Http\Controllers\UserProfileController::class, 'index'])->name('user-profile.index');

// Auth routes
Route::get('/prijava', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/prijava', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/odjava', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/registracija', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/registracija', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/geslo/ponastavitev', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/geslo/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/geslo/ponastavitev/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/geslo/ponastavitev', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/geslo/potrditev', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/geslo/potrditev', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);
Route::get('/email/potrditev', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/potrditev/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/poslji-ponovno', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');


