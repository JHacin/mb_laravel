<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnHelper;
use App\Helpers\Admin\CrudFieldHelper;
use App\Http\Requests\Admin\AdminCatLocationRequest;
use App\Models\CatLocation;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;

/**
 * Class Cat_locationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CatLocationCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(CatLocation::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.cat_locations'));
        $this->crud->setEntityNameStrings('Lokacija', 'Lokacije');
        $this->crud->setSubheading('Dodaj novo lokacijo', 'create');
        $this->crud->setSubheading('Uredi lokacijo', 'edit');
        $this->crud->setSubheading('Podatki lokacije', 'show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnHelper::id());
        $this->crud->addColumn(CrudColumnHelper::name());
        $this->crud->addColumn(CrudColumnHelper::address());
        $this->crud->addColumn(CrudColumnHelper::zipCode());
        $this->crud->addColumn(CrudColumnHelper::city());
        $this->crud->addColumn(CrudColumnHelper::country());
        $this->crud->addColumn(CrudColumnHelper::createdAt());
        $this->crud->addColumn(CrudColumnHelper::updatedAt());

        $this->crud->orderBy('updated_at', 'DESC');
    }

    /**
     * Define what is displayed in the Show view.
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn(CrudColumnHelper::id());
        $this->crud->addColumn(CrudColumnHelper::name());
        $this->crud->addColumn(CrudColumnHelper::address());
        $this->crud->addColumn(CrudColumnHelper::zipCode());
        $this->crud->addColumn(CrudColumnHelper::city());
        $this->crud->addColumn(CrudColumnHelper::country());
        $this->crud->addColumn(CrudColumnHelper::createdAt());
        $this->crud->addColumn(CrudColumnHelper::updatedAt());
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
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminCatLocationRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Ime',
            'type' => 'text',
            'attributes' => [
                'required' => 'required',
            ]
        ]);

        CrudFieldHelper::addAddressFields($this->crud);
    }
}
