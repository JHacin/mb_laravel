<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SponsorshipRequest;
use App\Models\Sponsorship;
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
 * Class SponsorshipCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SponsorshipCrudController extends CrudController
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
        CRUD::setModel(Sponsorship::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/botrovanja');
        CRUD::setEntityNameStrings('Botrovanje', 'Botrovanja');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'id',
            'label' => 'Šifra',
            'type' => 'number',
        ]);
        CRUD::addColumn([
            'name' => 'cat',
            'label' => 'Muca',
            'type' => 'relationship',
            'wrapper' => [
                'href' => function($crud, $column, $entry, $related_key) {
                    return backpack_url('muce', [$related_key, 'show']);
                },
                'target' => '_blank',
            ]
        ]);
        CRUD::addColumn([
            'name' => 'user',
            'label' => 'Uporabnik',
            'type' => 'relationship',
            'wrapper' => [
                'href' => function($crud, $column, $entry, $related_key) {
                    return backpack_url('uporabniki', [$related_key, 'show']);
                },
                'target' => '_blank',
            ]
        ]);
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Datum vnosa',
            'type' => 'datetime',
        ]);

        CRUD::orderBy('created_at', 'DESC');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SponsorshipRequest::class);

        CRUD::addField([
            'name' => 'cat_id',
            'label' => 'Muca',
            'type' => 'relationship',
        ]);
        CRUD::addField([
            'name' => 'user_id',
            'label' => 'Uporabnik',
            'type' => 'relationship',
        ]);
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
