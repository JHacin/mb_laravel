<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use Backpack\PermissionManager\app\Http\Controllers\RoleCrudController as BackpackRoleCrudController;

class RoleCrudController extends BackpackRoleCrudController
{
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
