<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnGenerator;
use App\Http\Requests\Admin\AdminCatRequest;
use App\Models\Cat;
use App\Models\CatLocation;
use App\Services\CatPhotoService;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    const DATE_OF_ARRIVAL_MH_COLUMN_DEFINITION = [
        'name' => 'date_of_arrival_mh',
        'label' => 'Datum sprejema v Mačjo hišo',
        'type' => 'date',
    ];

    const DATE_OF_ARRIVAL_BOTER_COLUMN_DEFINITION = [
        'name' => 'date_of_arrival_boter',
        'label' => 'Datum vstopa v botrstvo',
        'type' => 'date',
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
     * Since we have a global scope on the Cat model (queries will only return Cats with is_active=true),
     * we need to manually clear it - Backpack doesn't yet provide a standard way of bypassing scopes.
     */
    public function clearGlobalScopes()
    {
        /** @var Cat $catQuery */
        $catQuery = $this->crud->query;
        $this->crud->query = $catQuery->withoutGlobalScopes();
        /** @var Cat $catModel */
        $catModel = $this->crud->model;
        $catModel->clearGlobalScopes();
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
        $this->crud->setModel(Cat::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.cats'));
        $this->crud->setEntityNameStrings('Muca', 'Muce');
        $this->crud->setSubheading('Dodaj novo muco', 'create');
        $this->crud->setSubheading('Uredi muco', 'edit');
        $this->crud->setSubheading('Podatki muce', 'show');
        $this->clearGlobalScopes();
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
        $this->crud->addColumn(self::PHOTO_COLUMN_DEFINITION);
        $this->crud->addColumn(CrudColumnGenerator::name());
        $this->crud->addColumn(CrudColumnGenerator::genderLabel());
        $this->crud->addColumn(self::DATE_OF_ARRIVAL_MH_COLUMN_DEFINITION);
        $this->crud->addColumn(self::DATE_OF_ARRIVAL_BOTER_COLUMN_DEFINITION);
        $this->crud->addColumn(self::getLocationColumnDefinition());
        $this->crud->addColumn(CrudColumnGenerator::isActive(['label' => 'Objavljena']));
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->crud->orderBy('updated_at', 'DESC');

        $this->crud->addFilter(
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

        $this->crud->addFilter(
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

        $this->crud->addFilter(
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
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminCatRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Ime',
            'type' => 'text',
            'attributes' => [
                'required' => 'required',
            ]
        ]);
        $this->crud->addField([
            'name' => 'gender',
            'label' => 'Spol',
            'type' => 'radio',
            'options' => Cat::GENDER_LABELS,
            'inline' => true,
            'default' => Cat::GENDER_UNKNOWN,
        ]);
        $this->crud->addField([
            'name' => 'date_of_birth',
            'label' => 'Datum rojstva',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);
        $this->crud->addField([
            'name' => 'date_of_arrival_mh',
            'label' => 'Datum sprejema v zavetišče',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);
        $this->crud->addField([
            'name' => 'date_of_arrival_boter',
            'label' => 'Datum vstopa v botrstvo',
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);
        foreach ($this->catPhotoService::INDICES as $index) {
            $this->crud->addField([
                'name' => 'photo_' . $index,
                'label' => 'Slika ' . ($index + 1),
                'type' => 'cat_photo',
            ]);
        }
        $this->crud->addField([
            'name' => 'story',
            'label' => 'Zgodba',
            'type' => 'wysiwyg',
        ]);
        $this->crud->addField([
            'name' => 'location_id',
            'label' => 'Lokacija',
            'type' => 'relationship',
            'placeholder' => 'Izberi lokacijo',
        ]);
        $this->crud->addField([
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
            $photo = $cat->getPhotoByIndex($index);

            if ($photo) {
                $this->crud->modifyField('photo_' . $index, ['default' => $photo->url]);
            }
        }
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
        $this->crud->addColumn(self::PHOTO_COLUMN_DEFINITION);
        $this->crud->addColumn(CrudColumnGenerator::name());
        $this->crud->addColumn(CrudColumnGenerator::genderLabel());
        $this->crud->addColumn([
            'name' => 'story',
            'label' => 'Zgodba',
            'type' => 'text',
        ]);
        $this->crud->addColumn(self::DATE_OF_ARRIVAL_MH_COLUMN_DEFINITION);
        $this->crud->addColumn(self::DATE_OF_ARRIVAL_BOTER_COLUMN_DEFINITION);
        $this->crud->addColumn(CrudColumnGenerator::dateOfBirth());
        $this->crud->addColumn(self::getLocationColumnDefinition());
        $this->crud->addColumn(CrudColumnGenerator::isActive(['label' => 'Objavljena']));
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
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
        /** @var Request $request */
        $request = $this->crud->getRequest();

        foreach ($this->catPhotoService::INDICES as $index) {
            $base64 = $request->input('photo_' . $index);
            if (!$base64) {
                continue;
            }

            $filename = $this->catPhotoService->createImageFromBase64($request->get('photo_' . $index));
            $this->catPhotoService->create($cat, $filename, $index);
        }

        return $response;
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
        /** @var Request $request */
        $request = $this->crud->getRequest();

        foreach ($this->catPhotoService::INDICES as $index) {
            $existingImage = $cat->getPhotoByIndex($index);
            $imagePath = $request->input('photo_' . $index);

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
}
