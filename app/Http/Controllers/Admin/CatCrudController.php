<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnHelper;
use App\Http\Requests\CatRequest;
use App\Models\Cat;
use App\Models\CatLocation;
use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

/**
 * Class CatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CatCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use DeleteOperation;
    use ShowOperation;

    const PHOTO_COLUMN_DEFINITION = [
        'name' => 'photo',
        'label' => 'Slika',
        'type' => 'cat_photo',
    ];

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
     * @var CatPhotoService
     */
    private $catPhotoService;

    /**
     * CatCrudController constructor.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->catPhotoService = new CatPhotoService();
    }


    /**
     * @return array
     */
    protected function getLocationColumnDefinition()
    {
        return [
            'name' => 'location',
            'label' => 'Lokacija',
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.cat_locations'), [$related_key, 'show']);
                },
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
        CRUD::addColumn(self::PHOTO_COLUMN_DEFINITION);
        CRUD::addColumn(self::NAME_COLUMN_DEFINITION);
        CRUD::addColumn(self::GENDER_COLUMN_DEFINITION);
        CRUD::addColumn(self::DATE_OF_ARRIVAL_COLUMN_DEFINITION);
        CRUD::addColumn(self::getLocationColumnDefinition());
        CRUD::addColumn(self::IS_ACTIVE_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::CREATED_AT_COLUMN_DEFINITION);
        CRUD::addColumn(CrudColumnHelper::UPDATED_AT_COLUMN_DEFINITION);

        CRUD::orderBy('updated_at', 'DESC');

        CRUD::addFilter(
            [
                'name' => 'location_id',
                'type' => 'select2',
                'label' => 'Lokacija',
            ],
            function () {
                return CatLocation::all()->pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'location_id', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'gender',
                'type' => 'dropdown',
                'label' => 'Spol',
            ],
            Cat::GENDER_LABELS,
            function ($value) {
                $this->crud->addClause('where', 'gender', $value);
            }
        );

        CRUD::addFilter(
            [
                'name' => 'is_active',
                'type' => 'dropdown',
                'label' => 'Objavljena',
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
        CRUD::addColumn(self::PHOTO_COLUMN_DEFINITION);
        CRUD::addColumn(self::NAME_COLUMN_DEFINITION);
        CRUD::addColumn(self::GENDER_COLUMN_DEFINITION);
        CRUD::addColumn(self::STORY_COLUMN_DEFINITION);
        CRUD::addColumn(self::DATE_OF_ARRIVAL_COLUMN_DEFINITION);
        CRUD::addColumn(self::DATE_OF_BIRTH_COLUMN_DEFINITION);
        CRUD::addColumn(self::getLocationColumnDefinition());
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
            'attributes' => [
                'required' => 'required',
            ]
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
        foreach ($this->catPhotoService::INDICES as $index) {
            CRUD::addField([
                'name' => 'photo_' . $index,
                'label' => 'Slika ' . ($index + 1),
                'type' => 'cat_photo',
            ]);
        }
        CRUD::addField([
            'name' => 'story',
            'label' => 'Zgodba',
            'type' => 'wysiwyg',
        ]);
        CRUD::addField([
            'name' => 'location_id',
            'label' => 'Lokacija',
            'type' => 'relationship',
            'placeholder' => 'Izberi lokacijo',
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

        /** @var Cat $cat */
        $cat = $this->crud->getCurrentEntry();

        foreach ($this->catPhotoService::INDICES as $index) {
            /** @var CatPhoto $photo */
            $photo = $cat->getPhotoByIndex($index);

            if ($photo) {
                CRUD::modifyField('photo_' . $index, ['default' => $photo->getUrl()]);
            }
        }
    }


    /**
     * Update cat photos.
     *
     * @return Response
     */
    public function update()
    {
        /** @var Response $response */
        $response = $this->traitUpdate();

        /** @var Cat $cat */
        $cat = $this->crud->getCurrentEntry();
        $request = $this->crud->getRequest();

        foreach ($this->catPhotoService::INDICES as $index) {
            $existingImage = $cat->getPhotoByIndex($index);
            $imagePath = $request->get('photo_' . $index);

            if (!$imagePath) {
                if ($existingImage) {
                    try {
                        $existingImage->delete();
                    } catch (Exception $exception) {
                        continue;
                    }
                }

                continue;
            }

            // If it's a base64 string, it means the user selected a new image.
            if ($this->catPhotoService->isBase64ImageString($imagePath)) {
                if ($existingImage) {
                    try {
                        $existingImage->delete();
                    } catch (Exception $e) {
                        continue;
                    }
                }

                $filename = $this->catPhotoService->createImageFromBase64($imagePath);
                $this->catPhotoService->create($cat, $filename, $index);

                continue;
            }
        }

        return $response;
    }


    /**
     * Create cat photos & connect them to the created cat.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $response = $this->traitStore();

        /** @var Cat $cat */
        $cat = $this->crud->getCurrentEntry();
        $request = $this->crud->getRequest();

        foreach ($this->catPhotoService::INDICES as $index) {
            $base64 = $request->get('photo_' . $index);
            if (!$base64) {
                continue;
            }

            $filename = $this->catPhotoService->createImageFromBase64($request->get('photo_' . $index));
            $this->catPhotoService->create($cat, $filename, $index);
        }

        return $response;
    }
}
