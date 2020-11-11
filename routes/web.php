<?php

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CatSponsorshipController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Publicly visible pages
Route::get(config('routes.home'), [PagesController::class, 'index'])->name('home');
Route::get('/muce', [PagesController::class, 'catList'])->name('cat_list');
Route::get('/muce/{cat}', [PagesController::class, 'catDetails'])->name('cat_details');

// Cat sponsorship
Route::get('/muce/{cat}/postani-boter', [CatSponsorshipController::class, 'form'])->name('become_cat_sponsor');
Route::post('/muce/{cat}/postani-boter', [CatSponsorshipController::class, 'submit']);

// User pages
Route::get('/profil', [UserProfileController::class, 'index'])->name('user-profile');
Route::post('/profil', [UserProfileController::class, 'update']);

// Auth routes
Route::get(config('routes.login'), [LoginController::class, 'showLoginForm'])->name('login');
Route::post(config('routes.login'), [LoginController::class, 'login']);
Route::post('/odjava', [LoginController::class, 'logout'])->name('logout');
Route::get(config('routes.register'), [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post(config('routes.register'), [RegisterController::class, 'register']);
Route::get(config('routes.forgot_password'), [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/geslo/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/geslo/ponastavitev/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post(config('routes.forgot_password'), [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('/geslo/potrditev', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/geslo/potrditev', [ConfirmPasswordController::class, 'confirm']);
Route::get('/email/potrditev', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/potrditev/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/poslji-ponovno', [VerificationController::class, 'resend'])->name('verification.resend');
