<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Helpers\Admin\CrudColumnHelper;
use App\Helpers\CountryList;
use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Models\PersonData;
use App\Models\User;
use App\Services\UserMailService;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserCrudController extends BackpackUserCrudController
{
    use ShowOperation;

    const TAB_ACCOUNT_DATA = 'Račun';
    const TAB_PERSONAL_DATA = 'Osebni podatki';

    const FIRST_NAME_COLUMN_DEFINITION = [
        'name' => 'personData.first_name',
        'label' => 'Ime',
        'type' => 'text',
    ];

    const LAST_NAME_COLUMN_DEFINITION = [
        'name' => 'personData.last_name',
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

    /**
     * Define what is displayed in the List view.
     *
     * @return void
     */
    public function setupListOperation()
    {
        parent::setupListOperation();

        $this->crud->removeColumn('permissions');

        $this->crud->addColumn(self::FIRST_NAME_COLUMN_DEFINITION)->afterColumn('email');
        $this->crud->addColumn(self::LAST_NAME_COLUMN_DEFINITION)->afterColumn('personData.first_name');
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
    }

    /**
     * Add common fields (for create & update).
     *
     * @return void
     */
    protected function addUserFields()
    {
        parent::addUserFields();

        CRUD::modifyField('name', ['tab' => self::TAB_ACCOUNT_DATA]);
        CRUD::modifyField('email', ['tab' => self::TAB_ACCOUNT_DATA]);
        CRUD::modifyField('password', ['tab' => self::TAB_ACCOUNT_DATA]);
        CRUD::modifyField('password_confirmation', ['tab' => self::TAB_ACCOUNT_DATA]);
        /** @noinspection PhpParamsInspection */
        CRUD::modifyField(['roles', 'permissions'], ['tab' => self::TAB_ACCOUNT_DATA]);

        CRUD::addField([
            'name' => 'personData.first_name',
            'label' => 'Ime',
            'type' => 'text',
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.last_name',
            'label' => 'Priimek',
            'type' => 'text',
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.gender',
            'label' => 'Spol',
            'type' => 'radio',
            'options' => PersonData::GENDER_LABELS,
            'inline' => true,
            'default' => PersonData::GENDER_UNKNOWN,
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.phone',
            'label' => 'Telefon',
            'type' => 'text',
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.date_of_birth',
            'label' => 'Datum rojstva',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.address',
            'label' => 'Naslov',
            'type' => 'text',
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.zip_code',
            'label' => 'Poštna številka',
            'type' => 'text',
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.city',
            'label' => 'Kraj',
            'type' => 'text',
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'personData.country',
            'label' => 'Država',
            'type' => 'select2_from_array',
            'options' => CountryList::COUNTRY_NAMES,
            'allows_null' => true,
            'default' => CountryList::DEFAULT,
            'tab' => self::TAB_PERSONAL_DATA
        ]);
        CRUD::addField([
            'name' => 'is_active',
            'label' => 'Aktiviran',
            'type' => 'checkbox',
            'hint' => 'Uporabnik, ki ni aktiviran, se še ne more prijaviti v račun.',
            'tab' => self::TAB_ACCOUNT_DATA
        ]);
    }

    /**
     * Define what is displayed in the Create view.
     *
     * @return void
     */
    public function setupCreateOperation()
    {
        parent::setupCreateOperation();

        $this->crud->setValidation(AdminUserCreateRequest::class);

        CRUD::addField([
            'name' => 'should_send_welcome_email',
            'label' => 'Pošlji obvestilo o ustvarjenem računu?',
            'type' => 'checkbox',
            'hint' => 'Uporabnik bo na svoj email naslov prejel sporočilo, v katerem se mu izreče dobrodošlica.',
            'tab' => self::TAB_ACCOUNT_DATA,
        ]);
    }

    /**
     * Define what is displayed in the Update view.
     *
     * @return void
     */
    public function setupUpdateOperation()
    {
        parent::setupUpdateOperation();
        $this->crud->setValidation(AdminUserUpdateRequest::class);
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
            'name' => 'personData.gender_label',
            'label' => 'Spol',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'personData.date_of_birth',
            'label' => 'Datum rojstva',
            'type' => 'date',
        ]);
        CRUD::addColumn([
            'name' => 'personData.phone',
            'label' => 'Telefon',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'personData.address',
            'label' => 'Naslov',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'personData.zip_code',
            'label' => 'Poštna številka',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'personData.city',
            'label' => 'Kraj',
            'type' => 'text',
        ]);
        CRUD::addColumn([
            'name' => 'personData.country',
            'label' => 'Država',
            'type' => 'select_from_array',
            'options' => CountryList::COUNTRY_NAMES,
        ]);
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
    }

    /**
     * Actions taken after the user is inserted.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $response = parent::store();

        /** @var Request $request */
        $request = $this->crud->getRequest();

        if ($request->input('should_send_welcome_email', false)) {
            /** @var User $user */
            $user = $this->crud->getCurrentEntry();

            UserMailService::sendWelcomeEMail($user);
        }

        return $response;
    }
}
