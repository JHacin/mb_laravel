<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminCatLocationRequest;
use App\Models\CatLocation;
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

    /**
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
        $this->crud->enableExportButtons();
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn(CrudColumnGenerator::name());
        $this->crud->addColumn(CrudColumnGenerator::address());
        $this->crud->addColumn(CrudColumnGenerator::zipCode());
        $this->crud->addColumn(CrudColumnGenerator::city());
        $this->crud->addColumn(CrudColumnGenerator::country());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->crud->orderBy('updated_at', 'DESC');
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
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
            ],
            'wrapper' => [
                'dusk' => 'name-wrapper'
            ],
        ]);

        CrudFieldGenerator::addAddressFields($this->crud);
    }
}
