<?php

use Backpack\CRUD\app\Http\Controllers\Auth\LoginController;

Route::group([
    'namespace' => 'Backpack\CRUD\app\Http\Controllers',
    'middleware' => config('backpack.base.web_middleware', 'web'),
    'prefix' => config('backpack.base.route_prefix'),
], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('backpack.auth.login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])->name('backpack.auth.logout');
    Route::post('logout', [LoginController::class, 'logout']);
});

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::crud(config('routes.admin.cats'), 'CatCrudController');
    Route::crud(config('routes.admin.sponsorships'), 'SponsorshipCrudController');
    Route::post(config('routes.admin.sponsorships_cancel'), 'SponsorshipCrudController@cancelSponsorship')->name('admin.sponsorship_cancel');
    Route::crud(config('routes.admin.cat_locations'), 'CatLocationCrudController');
    Route::crud(config('routes.admin.sponsors'), 'SponsorCrudController');
    Route::post(config('routes.admin.sponsor_cancel_all_sponsorships'), 'SponsorCrudController@cancelAllSponsorships')->name('admin.sponsor_cancel_all_sponsorships');
    Route::crud(config('routes.admin.sponsorship_message_types'), 'SponsorshipMessageTypeCrudController');
    Route::crud(config('routes.admin.sponsorship_messages'), 'SponsorshipMessageCrudController');
    Route::get(config('routes.admin.get_messages_sent_to_sponsor'), 'SponsorshipMessageCrudController@getMessagesSentToSponsor')->name('admin.get_messages_sent_to_sponsor');
    Route::get(config('routes.admin.get_parsed_template_preview'), 'SponsorshipMessageCrudController@getParsedTemplatePreview')->name('admin.get_parsed_template_preview');
    Route::crud(config('routes.admin.news'), 'NewsCrudController');
    Route::crud(config('routes.admin.special_sponsorships'), 'SpecialSponsorshipCrudController');
});
