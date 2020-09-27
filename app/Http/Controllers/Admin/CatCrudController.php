<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CatRequest;
use App\Models\Cat;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;

/**
 * Class CatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CatCrudController extends CrudController
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
        CRUD::setModel(Cat::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/muce');
        CRUD::setEntityNameStrings('Muca', 'Muce');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label('Ime')->type('text');
        CRUD::addColumn([
            'name' => 'gender',
            'label' => 'Spol',
            'type' => 'model_function',
            'function_name' => 'getGenderLabel',
        ]);
        CRUD::column('date_of_arrival')->label('Datum sprejema')->type('date');
        CRUD::column('is_active')->label('Objavljena')->type('boolean');
        CRUD::column('created_at')->label('Datum objave')->type('date');
        CRUD::column('updated_at')->label('Zadnja sprememba')->type('date');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CatRequest::class);

        CRUD::field('name')->label('Ime')->type('text');
        CRUD::field('gender')->label('Spol')->type('text');
        CRUD::field('story')->label('Zgodba')->type('text');
        CRUD::field('date_of_birth')->label('Datum rojstva')->type('text');
        CRUD::field('date_of_arrival')->label('Datum sprejema')->type('text');
        CRUD::field('is_active')->label('Objavljena')->type('text');
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
}
