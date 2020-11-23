<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminCatRequest;
use App\Models\Cat;
use App\Models\CatLocation;
use App\Services\CatPhotoService;
use App\Utilities\Admin\CrudColumnGenerator;
use App\Utilities\Admin\CrudFieldGenerator;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @var CatPhotoService
     */
    private $catPhotoService;

    /**
     * CatCrudController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->catPhotoService = new CatPhotoService();
    }

    /**
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
        $this->clearModelGlobalScopes();
    }

    /**
     * @return void
     */
    public function clearModelGlobalScopes()
    {
        /** @var Cat $catQuery */
        $catQuery = $this->crud->query;
        $this->crud->query = $catQuery->withoutGlobalScopes();
        /** @var Cat $catModel */
        $catModel = $this->crud->model;
        $catModel->clearGlobalScopes();
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn([
            'name' => 'photo',
            'label' => 'Slika',
            'type' => 'cat_photo',
        ]);
        $this->crud->addColumn(CrudColumnGenerator::name());
        $this->crud->addColumn(CrudColumnGenerator::genderLabel());
        $this->crud->addColumn([
            'name' => 'date_of_arrival_mh',
            'label' => 'Datum sprejema v Mačjo hišo',
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'date_of_arrival_boter',
            'label' => 'Datum vstopa v botrstvo',
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'location',
            'label' => 'Lokacija',
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.cat_locations'), [$related_key, 'edit']);
                },
            ],
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('location', function (Builder $query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
                });
            }
        ]);
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
            ],
            'wrapper' => [
                'dusk' => 'add-cat-form-name-input-wrapper'
            ],
        ]);
        $this->crud->addField([
            'name' => 'gender',
            'label' => 'Spol',
            'type' => 'radio',
            'options' => Cat::GENDER_LABELS,
            'inline' => true,
            'default' => Cat::GENDER_UNKNOWN,
        ]);
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'date_of_birth',
            'label' => 'Datum rojstva',
            'wrapper' => [
                'dusk' => 'add-cat-form-date-of-birth-input-wrapper'
            ],
        ]));
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'date_of_arrival_mh',
            'label' => 'Datum sprejema v zavetišče',
            'wrapper' => [
                'dusk' => 'add-cat-form-date-of-arrival-mh-input-wrapper'
            ],
        ]));
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'date_of_arrival_boter',
            'label' => 'Datum vstopa v botrstvo',
            'wrapper' => [
                'dusk' => 'add-cat-form-date-of-arrival-boter-input-wrapper'
            ],
        ]));
        foreach ($this->catPhotoService::INDICES as $index) {
            $this->crud->addField([
                'name' => 'photo_' . $index,
                'label' => 'Slika ' . ($index + 1),
                'type' => 'cat_photo',
                'wrapper' => [
                    'dusk' => "add-cat-form-photo-$index-input-wrapper"
                ],
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
