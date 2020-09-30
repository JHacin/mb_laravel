<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnHelper;
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
     * @return array
     */
    protected function getCatColumnDefinition()
    {
        return [
            'name' => 'cat',
            'label' => 'Muca',
            'type' => 'relationship',
            'wrapper' => [
                'href' => function($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.cats'), [$related_key, 'show']);
                },
                'target' => '_blank',
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getUserColumnDefinition()
    {
        return [
            'name' => 'user',
            'label' => 'Uporabnik',
            'type' => 'relationship',
            'wrapper' => [
                'href' => function($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.users'), [$related_key, 'show']);
                },
                'target' => '_blank',
            ]
        ];
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        CRUD::setModel(Sponsorship::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsorships'));
        CRUD::setEntityNameStrings('Botrovanje', 'Botrovanja');
        CRUD::setSubheading('Dodaj novo botrovanje', 'create');
        CRUD::setSubheading('Uredi botrovanje', 'edit');
        CRUD::setSubheading('Podatki botrovanja', 'show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(CrudColumnHelper::ID_COLUMN_DEFINITION);
        CRUD::addColumn(self::getCatColumnDefinition());
        CRUD::addColumn(self::getUserColumnDefinition());
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);

        CRUD::orderBy('created_at', 'DESC');
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
        CRUD::addColumn(self::getCatColumnDefinition());
        CRUD::addColumn(self::getUserColumnDefinition());
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
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
            'placeholder' => 'Izberi muco',
        ]);
        CRUD::addField([
            'name' => 'user_id',
            'label' => 'Uporabnik',
            'type' => 'relationship',
            'placeholder' => 'Izberi uporabnika',
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
