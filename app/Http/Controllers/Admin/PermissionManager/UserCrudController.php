<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;

class UserCrudController extends BackpackUserCrudController
{
    /**
     * @inheritdoc
     */
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(backpack_url(config('routes.admin.users')));
    }
}
