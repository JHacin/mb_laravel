<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnHelper;
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

    const NAME_COLUMN_DEFINITION = [
        'name' => 'name',
        'label' => 'Ime',
        'type' => 'text',
    ];

    const GENDER_COLUMN_DEFINITION = [
        'name' => 'gender',
        'label' => 'Spol',
        'type' => 'model_function',
        'function_name' => 'getGenderLabel',
    ];

    const STORY_COLUMN_DEFINITION = [
        'name' => 'story',
        'label' => 'Zgodba',
        'type' => 'text',
    ];

    const DATE_OF_ARRIVAL_COLUMN_DEFINITION = [
        'name' => 'date_of_arrival',
        'label' => 'Datum sprejema',
        'type' => 'date',
    ];

    const DATE_OF_BIRTH_COLUMN_DEFINITION = [
        'name' => 'date_of_birth',
        'label' => 'Datum rojstva',
        'type' => 'date',
    ];

    const IS_ACTIVE_COLUMN_DEFINITION = [
        'name' => 'is_active',
        'label' => 'Objavljena',
        'type' => 'boolean',
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        CRUD::setModel(Cat::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.cats'));
        CRUD::setEntityNameStrings('Muca', 'Muce');
        CRUD::setSubheading('Dodaj novo muco', 'create');
        CRUD::setSubheading('Uredi muco', 'edit');
        CRUD::setSubheading('Podatki muce', 'show');
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
        CRUD::addColumn(self::GENDER_COLUMN_DEFINITION);
        CRUD::addColumn(self::DATE_OF_ARRIVAL_COLUMN_DEFINITION);
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);

        CRUD::orderBy('updated_at', 'DESC');

        CRUD::addFilter(
            [
                'type' => 'dropdown',
                'name' => 'is_active',
                'label' => 'Objavljena'
            ],
            [
                true => 'Da',
                false => 'Ne'
            ],
            function ($value) {
                $this->crud->addClause('where', 'is_active', $value);
            }
        );
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
        CRUD::addColumn(self::GENDER_COLUMN_DEFINITION);
        CRUD::addColumn(self::STORY_COLUMN_DEFINITION);
        CRUD::addColumn(self::DATE_OF_ARRIVAL_COLUMN_DEFINITION);
        CRUD::addColumn(self::DATE_OF_BIRTH_COLUMN_DEFINITION);
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
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
        CRUD::setValidation(CatRequest::class);

        CRUD::addField([
            'name' => 'name',
            'label' => 'Ime',
            'type' => 'text',
        ]);
        CRUD::addField([
            'name' => 'gender',
            'label' => 'Spol',
            'type' => 'radio',
            'options' => Cat::GENDER_LABELS,
            'inline' => true,
            'default' => Cat::GENDER_UNKNOWN,
        ]);
        CRUD::addField([
            'name' => 'date_of_birth',
            'label' => 'Datum rojstva',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);
        CRUD::addField([
            'name' => 'date_of_arrival',
            'label' => 'Datum sprejema v zavetišče',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);
        CRUD::addField([
            'name' => 'story',
            'label' => 'Zgodba',
            'type' => 'wysiwyg',
        ]);
        CRUD::addField([
            'name' => 'is_active',
            'label' => 'Objavljena',
            'type' => 'checkbox',
            'hint' => 'Ali naj bo muca javno vidna (npr. na seznamu vseh muc).',
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
