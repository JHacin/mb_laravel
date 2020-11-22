<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Models\User;
use App\Services\UserMailService;
use App\Utilities\Admin\CrudColumnGenerator;
use App\Utilities\Admin\CrudFieldGenerator;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserCrudController extends BackpackUserCrudController
{
    /**
     * @var UserMailService
     */
    protected $userMailService;

    /**
     * UserCrudController constructor.
     * @param $userMailService
     */
    public function __construct(UserMailService $userMailService)
    {
        parent::__construct();
        $this->userMailService = $userMailService;
    }


    /**
     * @inheritDoc
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

        $this->crud->modifyColumn('name', ['label' => trans('user.name')]);

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

        $this->crud->modifyField('name', ['label' => trans('user.name')]);

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

            $this->userMailService->sendWelcomeEMail($user);
        }

        return $response;
    }
}
