<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Helpers\Admin\CrudColumnHelper;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;

class UserCrudController extends BackpackUserCrudController
{
    use ShowOperation;

    const NAME_COLUMN_DEFINITION = [
        'name' => 'name',
        'label' => 'Ime',
        'type' => 'text',
    ];

    const EMAIL_COLUMN_DEFINITION = [
        'name' => 'email',
        'label' => 'Email',
        'type' => 'text',
    ];

    const EMAIL_VERIFIED_AT_COLUMN_DEFINITION = [
        'name' => 'email_verified_at',
        'label' => 'Datum potrditve email naslova',
        'type' => 'date',
    ];

    /**
     * @inheritdoc
     */
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(backpack_url(config('routes.admin.users')));
    }

    /**
     * Define what is displayed in the Show view.
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        CRUD::set('show.setFromDb', false);

        CRUD::addColumn(CrudColumnHelper::ID_COLUMN_DEFINITION);
        CRUD::addColumn(self::NAME_COLUMN_DEFINITION);
        CRUD::addColumn(self::EMAIL_COLUMN_DEFINITION);
        CRUD::addColumn(self::EMAIL_VERIFIED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
    }
}
