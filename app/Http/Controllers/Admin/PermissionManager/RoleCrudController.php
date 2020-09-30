<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use Backpack\PermissionManager\app\Http\Controllers\RoleCrudController as BackpackRoleCrudController;

class RoleCrudController extends BackpackRoleCrudController
{
    /**
     * @inheritdoc
     */
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(backpack_url(config('routes.admin.roles')));
    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'label',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);

        parent::setupListOperation();

        $this->crud->removeColumn('name');
    }

}
