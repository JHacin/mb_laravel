<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use App\Http\Controllers\Admin\CatPhotoController;

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud(config('routes.admin.cats'), 'CatCrudController');
    Route::crud(config('routes.admin.sponsorships'), 'SponsorshipCrudController');
    Route::crud(config('routes.admin.cat_locations'), 'CatLocationCrudController');
    Route::post(config('routes.admin.cat_photos'), [CatPhotoController::class, 'upload'])->name('cat_photos.upload');
    Route::delete(config('routes.admin.cat_photos') . '/{filename}', [CatPhotoController::class, 'delete'])->name('cat_photos.delete');

}); // this should be the absolute last line of this file
