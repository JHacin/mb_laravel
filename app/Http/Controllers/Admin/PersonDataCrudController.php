<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnGenerator;
use App\Helpers\Admin\CrudFieldGenerator;
use App\Http\Requests\Admin\AdminPersonDataRequest;
use App\Models\PersonData;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
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
    use ShowOperation;

    /**
     * @return void
     */
    protected function hideDataForRegisteredUsers()
    {
        $this->crud->addClause('where', PersonData::ATTR__USER_ID, null);
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
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
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
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
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminPersonDataRequest::class);
        CrudFieldGenerator::addPersonDataFields($this->crud);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
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
        $this->crud->addColumn(CrudColumnGenerator::email());
        $this->crud->addColumn(CrudColumnGenerator::firstName());
        $this->crud->addColumn(CrudColumnGenerator::lastName());
        $this->crud->addColumn(CrudColumnGenerator::genderLabel());
        $this->crud->addColumn(CrudColumnGenerator::dateOfBirth());
        $this->crud->addColumn(CrudColumnGenerator::phone());
        $this->crud->addColumn(CrudColumnGenerator::address());
        $this->crud->addColumn(CrudColumnGenerator::city());
        $this->crud->addColumn(CrudColumnGenerator::zipCode());
        $this->crud->addColumn(CrudColumnGenerator::country());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
    }
}
