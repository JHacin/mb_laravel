<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CatListController;
use App\Http\Controllers\CatSponsorshipController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Publicly visible pages
Route::get(config('routes.home'), [PagesController::class, 'index'])->name('home');
Route::get(config('routes.why_become_sponsor'), [PagesController::class, 'whyBecomeSponsor'])->name('why_become_sponsor');
Route::get('/muce', [CatListController::class, 'index'])->name('cat_list');
Route::get('/muce/{cat}', [PagesController::class, 'catDetails'])->name('cat_details');

// Cat sponsorship
Route::get(config('routes.cat_sponsorship_form'),
    [CatSponsorshipController::class, 'form'])->name('become_cat_sponsor');
Route::post(config('routes.cat_sponsorship_form'), [CatSponsorshipController::class, 'submit']);

// User pages
Route::get(config('routes.user_profile'), [UserProfileController::class, 'index'])->name('user-profile');
Route::post(config('routes.user_profile'), [UserProfileController::class, 'update']);

// Auth routes
Route::get(config('routes.login'), [LoginController::class, 'showLoginForm'])->name('login');
Route::post(config('routes.login'), [LoginController::class, 'login']);
Route::post('/odjava', [LoginController::class, 'logout'])->name('logout');
Route::get(config('routes.register'), [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post(config('routes.register'), [RegisterController::class, 'register']);
Route::get(config('routes.forgot_password'),
    [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/geslo/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get(config('routes.reset_password_form'), [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post(config('routes.forgot_password'), [ResetPasswordController::class, 'reset'])->name('password.update');
