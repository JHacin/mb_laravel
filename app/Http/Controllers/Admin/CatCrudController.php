<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ClearsModelGlobalScopes;
use App\Http\Controllers\Admin\Traits\CrudFilterHelpers;
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
use Backpack\ReviseOperation\ReviseOperation;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CatCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }
    use DeleteOperation;
    use ReviseOperation;
    use CrudFilterHelpers, ClearsModelGlobalScopes;

    private CatPhotoService $catPhotoService;

    public function __construct()
    {
        parent::__construct();
        $this->catPhotoService = new CatPhotoService();
    }

    /**
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
        $this->crud->addButtonFromModelFunction('line', 'open_view', 'openViewFromCrud');
        $this->crud->enableExportButtons();
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn([
            'name' => 'photo',
            'label' => trans('cat.photo'),
            'type' => 'cat_photo',
        ]);
        $this->crud->addColumn(CrudColumnGenerator::name());
        $this->crud->addColumn([
            'name' => 'status_label',
            'label' => trans('cat.status'),
            'type' => 'text'
        ]);
        $this->crud->addColumn(CrudColumnGenerator::genderLabel());
        $this->crud->addColumn([
            'name' => 'date_of_arrival_mh',
            'label' => trans('cat.date_of_arrival_mh'),
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'date_of_arrival_boter',
            'label' => trans('cat.date_of_arrival_boter'),
            'type' => 'date',
        ]);
        $this->crud->addColumn([
            'name' => 'location',
            'label' => trans('cat.location'),
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
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->crud->orderBy('updated_at', 'DESC');

        $this->addFilters();
    }

    protected function addFilters()
    {
        $this->crud->addFilter(
            [
                'name' => 'location_id',
                'type' => 'select2',
                'label' => trans('cat.location'),
            ],
            function () {
                return CatLocation::all()->pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'location_id', $value);
            }
        );

        $this->addDropdownFilter('gender', trans('cat.gender'), Cat::GENDER_LABELS);
        $this->addDropdownFilter('status', trans('cat.status'), Cat::STATUS_LABELS);
        $this->addBooleanFilter('is_group', trans('cat.is_group'));
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminCatRequest::class);

        $this->crud->addField([
            'name' => 'name',
            'label' => trans('cat.name'),
            'type' => 'text',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'name-input-wrapper'
            ],
        ]);
        $this->crud->addField([
            'name' => 'gender',
            'label' => trans('cat.gender'),
            'type' => 'radio',
            'options' => Cat::GENDER_LABELS,
            'inline' => true,
            'wrapper' => [
                'dusk' => 'gender-input-wrapper'
            ],
        ]);
        $this->crud->addField([
            'name' => 'status',
            'label' => trans('cat.status'),
            'type' => 'select_from_array',
            'options' => Cat::STATUS_LABELS,
            'allows_null' => false,
            'default' => Cat::STATUS_NOT_SEEKING_SPONSORS,
            'required' => true,
            'wrapper' => [
                'dusk' => 'status-input-wrapper'
            ],
            'hint' =>
                '<em>išče botre</em>: objavljena, botrstvo je možno<br>' .
                '<em>trenutno ne išče botrov</em>: objavljena, botrstvo ni možno, prikazana je opomba<br>' .
                '<em>ne išče botrov</em>: ni objavljena, botrstvo ni možno<br>' .
                '<em>v novem domu</em>: ni objavljena, botrstvo ni možno<br>' .
                '<em>RIP</em>: ni objavljena, botrstvo ni možno<br>'
        ]);
        $this->crud->addField([
            'name' => 'is_group',
            'label' => trans('cat.is_group') . '?',
            'type' => 'radio',
            'options' => [
                1 => 'Da',
                0 => 'Ne',
            ],
            'default' => 0,
            'inline' => true,
            'wrapper' => [
                'dusk' => 'is_group-input-wrapper'
            ],
            'hint' => 'Ali naj se ta vnos obravnava kot druge skupine - Čombe, Pozitivčki, Bubiji...',
        ]);
        $this->crud->addField([
            'name' => 'story_short',
            'label' => trans('cat.story_short'),
            'type' => 'textarea',
            'hint' => 'Največ ' . config('validation.cat.story_short_maxlength') . ' znakov.',
            'attributes' => [
                'maxlength' => config('validation.cat.story_short_maxlength'),
                'required' => 'required',
                'rows' => 3,
            ],
        ]);
        $this->crud->addField([
            'name' => 'story',
            'label' => trans('cat.story'),
            'type' => 'wysiwyg',
        ]);
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'date_of_birth',
            'label' => trans('cat.date_of_birth'),
            'wrapper' => [
                'dusk' => 'date-of-birth-input-wrapper'
            ],
        ]));
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'date_of_arrival_mh',
            'label' => trans('cat.date_of_arrival_mh'),
            'wrapper' => [
                'dusk' => 'date-of-arrival-mh-input-wrapper'
            ],
        ]));
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'date_of_arrival_boter',
            'label' => trans('cat.date_of_arrival_boter'),
            'wrapper' => [
                'dusk' => 'date-of-arrival-boter-input-wrapper'
            ],
        ]));
        foreach ($this->catPhotoService::INDICES as $index) {
            $this->crud->addField([
                'name' => 'photo_' . $index,
                'label' => trans('cat.photo') . ' ' . ($index + 1),
                'type' => 'cat_photo',
                'wrapper' => [
                    'dusk' => "photo-$index-input-wrapper"
                ],
            ]);
        }
        $this->crud->addField([
            'name' => 'location_id',
            'label' => trans('cat.location'),
            'type' => 'relationship',
            'placeholder' => 'Izberi lokacijo',
            'wrapper' => [
                'dusk' => 'location-input-wrapper'
            ],
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

    public function store(): Response
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

            $this->catPhotoService->create($cat, $request->get('photo_' . $index), $index);
        }

        return $response;
    }

    public function update(): Response
    {
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
                    } catch (Exception) {
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
                    } catch (Exception) {
                        continue;
                    }
                }

                $this->catPhotoService->create($cat, $imagePath, $index);
            }
        }

        return $response;
    }
}
