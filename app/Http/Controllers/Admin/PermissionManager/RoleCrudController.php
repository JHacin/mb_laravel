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

        $this->crud->modifyColumn(
            'users',
            [
                'wrapper' => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url(config('routes.admin.users') . '?role=' . $entry->getKey());
                    },
                ],
                'suffix' => ' uporabnikov',
            ]
        );

        $this->crud->removeColumn('name');
    }

}
