<?php

/*
|--------------------------------------------------------------------------
| Backpack\PermissionManager Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Backpack\PermissionManager package.
|
*/

Route::group([
    'namespace'  => 'App\Http\Controllers\Admin\PermissionManager',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
], function () {
    Route::crud(config('routes.admin.permissions'), 'PermissionCrudController');
    Route::crud(config('routes.admin.roles'), 'RoleCrudController');
    Route::crud(config('routes.admin.users'), 'UserCrudController');
});
