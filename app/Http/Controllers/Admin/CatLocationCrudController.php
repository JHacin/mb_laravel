<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnHelper;
use App\Helpers\CountryList;
use App\Http\Requests\Admin\AdminCatLocationRequest;
use App\Models\CatLocation;
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

    const NAME_COLUMN_DEFINITION = [
        'name' => 'name',
        'label' => 'Ime',
        'type' => 'text',
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        CRUD::setModel(CatLocation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.cat_locations'));
        CRUD::setEntityNameStrings('Lokacija', 'Lokacije');
        CRUD::setSubheading('Dodaj novo lokacijo', 'create');
        CRUD::setSubheading('Uredi lokacijo', 'edit');
        CRUD::setSubheading('Podatki lokacije', 'show');
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
        CRUD::addColumn(self::NAME_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::ADDRESS_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::ZIP_CODE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CITY_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::COUNTRY_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);

        CRUD::orderBy('updated_at', 'DESC');
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
        CRUD::addColumn(self::NAME_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::ADDRESS_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::ZIP_CODE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CITY_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::COUNTRY_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);
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
        CRUD::setValidation(AdminCatLocationRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label' => 'Ime',
            'type' => 'text',
            'attributes' => [
                'required' => 'required',
            ]
        ]);
        CRUD::addField([
            'name' => 'address',
            'label' => 'Naslov',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'zip_code',
            'label' => 'Poštna številka',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'city',
            'label' => 'Kraj',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'country',
            'label' => 'Država',
            'type' => 'select2_from_array',
            'options' => CountryList::COUNTRY_NAMES,
            'allows_null' => true,
            'default' => CountryList::DEFAULT
        ]);
    }
}
