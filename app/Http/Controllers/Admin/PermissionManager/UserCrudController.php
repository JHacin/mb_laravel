<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Helpers\Admin\CrudColumnGenerator;
use App\Helpers\Admin\CrudFieldGenerator;
use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Models\User;
use App\Services\UserMailService;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserCrudController extends BackpackUserCrudController
{
    use ShowOperation;

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

        $this->crud->addColumn(CrudColumnGenerator::firstName(['name' => 'personData.first_name']))->afterColumn('email');
        $this->crud->addColumn(CrudColumnGenerator::lastName(['name' => 'personData.last_name']))->afterColumn('personData.first_name');
        $this->crud->addColumn(CrudColumnGenerator::isActive());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
    }

    /**
     * Add common fields (for create & update).
     *
     * @return void
     */
    protected function addUserFields()
    {
        parent::addUserFields();

        CrudFieldGenerator::addPersonDataFields($this->crud);

        $this->crud->addField([
            'name' => 'is_active',
            'label' => trans('user.is_active'),
            'type' => 'checkbox',
            'hint' => 'Uporabnik, ki ni aktiviran, se še ne more prijaviti v račun.',
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

        $this->crud->addField([
            'name' => 'should_send_welcome_email',
            'label' => 'Pošlji obvestilo o ustvarjenem računu?',
            'type' => 'checkbox',
            'hint' => 'Uporabnik bo na svoj email naslov prejel sporočilo, v katerem se mu izreče dobrodošlica.',
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
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('user.name'),
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'email',
            'label' => trans('user.email'),
            'type' => 'text',
        ]);
        $this->crud->addColumn(CrudColumnGenerator::firstName(['name' => 'personData.first_name']));
        $this->crud->addColumn(CrudColumnGenerator::lastName(['name' => 'personData.last_name']));
        $this->crud->addColumn(CrudColumnGenerator::genderLabel(['name' => 'personData.gender_label']));
        $this->crud->addColumn(CrudColumnGenerator::dateOfBirth(['name' => 'personData.date_of_birth']));
        $this->crud->addColumn(CrudColumnGenerator::phone(['name' => 'personData.phone']));
        $this->crud->addColumn(CrudColumnGenerator::address(['name' => 'personData.address']));
        $this->crud->addColumn(CrudColumnGenerator::zipCode(['name' => 'personData.zip_code']));
        $this->crud->addColumn(CrudColumnGenerator::city(['name' => 'personData.city']));
        $this->crud->addColumn(CrudColumnGenerator::country(['name' => 'personData.country']));
        $this->crud->addColumn(CrudColumnGenerator::isActive());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
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
