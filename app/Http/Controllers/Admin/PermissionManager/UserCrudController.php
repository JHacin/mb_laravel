<?php

namespace App\Http\Controllers\Admin\PermissionManager;

use App\Http\Controllers\Admin\Traits\CrudFilterHelpers;
use App\Http\Requests\Admin\AdminUserCreateRequest;
use App\Http\Requests\Admin\AdminUserUpdateRequest;
use App\Mail\UserMail;
use App\Models\User;
use App\Utilities\Admin\CrudColumnGenerator;
use App\Utilities\Admin\CrudFieldGenerator;
use Backpack\PermissionManager\app\Http\Controllers\UserCrudController as BackpackUserCrudController;
use Backpack\ReviseOperation\ReviseOperation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserCrudController extends BackpackUserCrudController
{
    use CrudFilterHelpers;
    use ReviseOperation;

    private UserMail $userMail;

    public function __construct(UserMail $userMail)
    {
        parent::__construct();
        $this->userMail = $userMail;
    }

    /**
     * @inheritDoc
     */
    public function setup()
    {
        parent::setup();
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.users'));
        $this->crud->enableExportButtons();
    }

    /**
     * Define what is displayed in the List view.
     *
     * @return void
     */
    public function setupListOperation()
    {
        parent::setupListOperation();
        $this->crud->addColumn(CrudColumnGenerator::id())->makeFirstColumn();

        $this->crud->removeColumn('permissions');

        $this->crud->modifyColumn('name', ['label' => trans('user.name')]);

        $this->crud->addColumn(CrudColumnGenerator::firstName([
            'name' => 'personData.first_name',
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('personData', function (Builder $query) use ($searchTerm) {
                    $query->where('first_name', 'like', "%$searchTerm%");
                });
            },
        ]))->afterColumn('email');
        $this->crud->addColumn(CrudColumnGenerator::lastName([
            'name' => 'personData.last_name',
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('personData', function (Builder $query) use ($searchTerm) {
                    $query->where('last_name', 'like', "%$searchTerm%");
                });
            },
        ]))->afterColumn('personData.first_name');
        $this->crud->addColumn(CrudColumnGenerator::isActive());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->addBooleanFilter('is_active', trans('user.is_active'));
    }

    /**
     * Add common fields (for create & update).
     *
     * @return void
     */
    protected function addUserFields()
    {
        parent::addUserFields();

        $this->crud->modifyField('name', [
            'label' => trans('user.name'),
            'wrapper' => [
                'dusk' => 'name-input-wrapper'
            ],
        ]);
        $this->crud->modifyField('email', [
            'wrapper' => [
                'dusk' => 'email-input-wrapper'
            ],
        ]);
        $this->crud->modifyField('password', [
            'wrapper' => [
                'dusk' => 'password-input-wrapper'
            ],
        ]);

        CrudFieldGenerator::addPersonDataFields($this->crud);

        $this->crud->addField([
            'name' => 'is_active',
            'label' => trans('user.is_active'),
            'type' => 'checkbox',
            'hint' => 'Uporabnik, ki ni aktiviran, se še ne more prijaviti v račun.',
            'wrapper' => [
                'dusk' => 'is_active-input-wrapper',
            ],
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
            'wrapper' => [
                'dusk' => 'should_send_welcome_email-input-wrapper',
            ],
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
    public function store(): RedirectResponse
    {
        $response = parent::store();

        /** @var Request $request */
        $request = $this->crud->getRequest();

        if ($request->input('should_send_welcome_email', false)) {
            /** @var User $user */
            $user = $this->crud->getCurrentEntry();

            $this->userMail->sendWelcomeEmail($user);
        }

        return $response;
    }
}
