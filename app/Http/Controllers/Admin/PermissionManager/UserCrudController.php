<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Helpers\Admin\CrudColumnHelper;
use App\Helpers\CountryList;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;

class UserCrudController extends BackpackUserCrudController
{
    use ShowOperation;

    const FIRST_NAME_COLUMN_DEFINITION = [
        'name' => 'first_name',
        'label' => 'Ime',
        'type' => 'text',
    ];

    const LAST_NAME_COLUMN_DEFINITION = [
        'name' => 'last_name',
        'label' => 'Priimek',
        'type' => 'text',
    ];

    const IS_ACTIVE_COLUMN_DEFINITION = [
        'name' => 'is_active',
        'label' => 'Aktiviran',
        'type' => 'boolean',
    ];

    /**
     * @inheritdoc
     */
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(backpack_url(config('routes.admin.users')));
    }

    protected function addUserFields()
    {
        parent::addUserFields();
        CRUD::addField([
            'name' => 'first_name',
            'label' => 'Ime',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'last_name',
            'label' => 'Priimek',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'gender',
            'label' => 'Spol',
            'type' => 'radio',
            'options' => User::GENDER_LABELS,
            'inline' => true,
            'default' => User::GENDER_UNKNOWN,
        ]);
        CRUD::addField([
            'name' => 'phone',
            'label' => 'Telefon',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'date_of_birth',
            'label' => 'Datum rojstva',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);
        CRUD::addField([
            'name' => 'address',
            'label' => 'Naslov',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'zip_code',
            'label' => 'Poštna številka',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'city',
            'label' => 'Kraj',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'country',
            'label' => 'Država',
            'type' => 'select2_from_array',
            'options' => CountryList::COUNTRY_NAMES,
            'allows_null' => true,
            'default' => 'SI'
        ]);
        CRUD::addField([
            'name' => 'is_active',
            'label' => 'Aktiviran',
            'type' => 'checkbox',
            'hint' => 'Uporabnik, ki ni aktiviran, se še ne more prijaviti v račun.',
        ]);
    }

    public function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->removeColumn('permissions');

        $this->crud->addColumn(self::FIRST_NAME_COLUMN_DEFINITION)->afterColumn('email');
        $this->crud->addColumn(self::LAST_NAME_COLUMN_DEFINITION)->afterColumn('first_name');
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
    }

    public function setupCreateOperation()
    {
        parent::setupCreateOperation();
        $this->crud->setValidation(UserCreateRequest::class);
    }

    public function setupUpdateOperation()
    {
        parent::setupUpdateOperation();
        $this->crud->setValidation(UserUpdateRequest::class);
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
        CRUD::addColumn([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'email',
            'label' => trans('backpack::permissionmanager.email'),
            'type' => 'text',
        ]);
        CRUD::addColumn(self::FIRST_NAME_COLUMN_DEFINITION);
        CRUD::addColumn(self::LAST_NAME_COLUMN_DEFINITION);
        CRUD::addColumn([
            'name' => 'gender',
            'label' => 'Spol',
            'type' => 'model_function',
            'function_name' => 'getGenderLabel',
        ]);
        CRUD::addColumn([
            'name' => 'date_of_birth',
            'label' => 'Datum rojstva',
            'type' => 'date',
        ]);
        CRUD::addColumn([
            'name' => 'phone',
            'label' => 'Telefon',
            'type' => 'text',
        ]);
        CRUD::addColumn(CrudColumnHelper::ADDRESS_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::ZIP_CODE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CITY_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::COUNTRY_COLUMN_DEFINITION);
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
    }
}
