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

    protected $idColumnDefinition = [
        'name' => 'id',
        'label' => 'Šifra',
        'type' => 'number',
    ];

    protected $nameColumnDefinition = [
        'name' => 'name',
        'label' => 'Ime',
        'type' => 'text',
    ];

    protected $genderColumnDefinition = [
        'name' => 'gender',
        'label' => 'Spol',
        'type' => 'model_function',
        'function_name' => 'getGenderLabel',
    ];

    protected $storyColumnDefinition = [
        'name' => 'story',
        'label' => 'Zgodba',
        'type' => 'text',
    ];

    protected $dateOfArrivalColumnDefinition = [
        'name' => 'date_of_arrival',
        'label' => 'Datum sprejema',
        'type' => 'date',
    ];

    protected $dateOfBirthColumnDefinition = [
        'name' => 'date_of_birth',
        'label' => 'Datum rojstva',
        'type' => 'date',
    ];

    protected $isActiveColumnDefinition = [
        'name' => 'is_active',
        'label' => 'Objavljena',
        'type' => 'boolean',
    ];

    protected $createdAtColumnDefinition = [
        'name' => 'created_at',
        'label' => 'Datum vnosa',
        'type' => 'datetime',
    ];

    protected $updatedAtColumnDefinition = [
        'name' => 'updated_at',
        'label' => 'Zadnja sprememba',
        'type' => 'datetime',
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
        CRUD::addColumn($this->idColumnDefinition);
        CRUD::addColumn($this->nameColumnDefinition);
        CRUD::addColumn($this->genderColumnDefinition);
        CRUD::addColumn($this->dateOfArrivalColumnDefinition);
        CRUD::addColumn($this->isActiveColumnDefinition);
        CRUD::addColumn($this->createdAtColumnDefinition);
        CRUD::addColumn($this->updatedAtColumnDefinition);

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

        CRUD::addColumn($this->idColumnDefinition);
        CRUD::addColumn($this->nameColumnDefinition);
        CRUD::addColumn($this->genderColumnDefinition);
        CRUD::addColumn($this->storyColumnDefinition);
        CRUD::addColumn($this->dateOfArrivalColumnDefinition);
        CRUD::addColumn($this->dateOfBirthColumnDefinition);
        CRUD::addColumn($this->isActiveColumnDefinition);
        CRUD::addColumn($this->createdAtColumnDefinition);
        CRUD::addColumn($this->updatedAtColumnDefinition);
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
