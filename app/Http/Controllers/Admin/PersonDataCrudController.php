<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminPersonDataRequest;
use App\Models\PersonData;
use App\Utilities\Admin\CrudColumnGenerator;
use App\Utilities\Admin\CrudFieldGenerator;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;

/**
 * Class PersonDataCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PersonDataCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;

    /**
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(PersonData::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.person_data'));
        $this->crud->setEntityNameStrings('Neregistiran boter', 'Neregistrirani botri');
        $this->hideDataForRegisteredUsers();
    }

    /**
     * @return void
     */
    protected function hideDataForRegisteredUsers()
    {
        $this->crud->addClause('where', 'user_id', null);
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn(CrudColumnGenerator::email());
        $this->crud->addColumn(CrudColumnGenerator::firstName());
        $this->crud->addColumn(CrudColumnGenerator::lastName());
        $this->crud->addColumn(CrudColumnGenerator::genderLabel());
        $this->crud->addColumn(CrudColumnGenerator::address());
        $this->crud->addColumn(CrudColumnGenerator::city());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminPersonDataRequest::class);

        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => trans('user.email'),
            'attributes' => [
                'required' => 'required'
            ]
        ]);
        CrudFieldGenerator::addPersonDataFields($this->crud);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
