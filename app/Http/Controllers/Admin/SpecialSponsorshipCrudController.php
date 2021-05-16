<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\CrudFilterHelpers;
use App\Http\Requests\Admin\AdminSpecialSponsorshipRequest;
use App\Models\PersonData;
use App\Models\SpecialSponsorship;
use App\Utilities\Admin\CrudColumnGenerator;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class SpecialSponsorshipCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SpecialSponsorshipCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use CrudFilterHelpers;

    /**
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(SpecialSponsorship::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.special_sponsorships'));
        $this->crud->setEntityNameStrings('Posebno botrstvo', 'Posebna botrstva');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn([
            'name' => 'type_label',
            'label' => trans('special_sponsorship.type'),
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'personData',
            'label' => trans('sponsor.sponsor'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.sponsors'), [$related_key, 'edit']);
                },
            ],
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('personData', function (Builder $query) use ($searchTerm) {
                    $query
                        ->where('email', 'like', "%$searchTerm%")
                        ->orWhere('id', 'like', "%$searchTerm%");
                });
            }
        ]);
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->addFilters();
    }

    protected function addFilters()
    {
        $this->addDropdownFilter('type', trans('special_sponsorship.type'), SpecialSponsorship::TYPE_LABELS);

        $this->crud->addFilter(
            [
                'name' => 'personData',
                'type' => 'select2',
                'label' => trans('sponsor.sponsor'),
            ],
            function () {
                return PersonData::all()->pluck('email_and_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'person_data_id', $value);
            }
        );
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminSpecialSponsorshipRequest::class);

        $this->crud->addField([
            'name' => 'type',
            'label' => trans('special_sponsorship.type'),
            'type' => 'select_from_array',
            'options' => SpecialSponsorship::TYPE_LABELS,
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'type-input-wrapper'
            ],
        ]);

        $this->crud->addField([
            'name' => 'personData',
            'label' => trans('sponsor.sponsor'),
            'type' => 'relationship',
            'placeholder' => 'Izberi botra',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'personData-wrapper'
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
