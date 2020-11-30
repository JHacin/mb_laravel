<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminSponsorshipRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
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

    /**
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(Sponsorship::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsorships'));
        $this->crud->setEntityNameStrings('Botrovanje', 'Botrovanja');
        $this->crud->setSubheading('Dodaj novo botrovanje', 'create');
        $this->crud->setSubheading('Uredi botrovanje', 'edit');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn([
            'name' => 'cat',
            'label' => trans('cat.cat'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.cats'), [$related_key, 'edit']);
                },
            ],
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('cat', function (Builder $query) use ($searchTerm) {
                    $query
                        ->where('name', 'like', "%$searchTerm%")
                        ->orWhere('id', 'like', "%$searchTerm%");
                });
            }
        ]);
        $this->crud->addColumn([
            'name' => 'personData',
            'label' => trans('sponsor.sponsor'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    /** @var Sponsorship $entry */
                    $isUser = $entry->personData->belongsToRegisteredUser();
                    $route = $isUser ? config('routes.admin.users') : config('routes.admin.person_data');
                    $id = $isUser ? $entry->personData->user_id : $related_key;

                    return backpack_url($route, [$id, 'edit']);
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
        $this->crud->addColumn(CrudColumnGenerator::moneyColumn([
            'name' => 'monthly_amount',
            'label' => trans('admin.sponsorship_monthly_amount')
        ]));
        $this->crud->addColumn([
            'name' => 'is_anonymous',
            'label' => trans('sponsorship.is_anonymous'),
            'type' => 'boolean',
        ]);
        $this->crud->addColumn([
            'name' => 'is_active',
            'label' => trans('sponsorship.is_active'),
            'type' => 'boolean',
        ]);
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn([
            'name' => 'ended_at',
            'label' => trans('sponsorship.ended_at'),
            'type' => 'datetime',
        ]);
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->addFilter(
            [
                'name' => 'cat',
                'type' => 'select2',
                'label' => trans('cat.cat'),
            ],
            function () {
                return Cat::all()->pluck('name_and_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'cat_id', $value);
            }
        );

        $this->crud->addFilter(
            [
                'name' => 'personData',
                'type' => 'select2',
                'label' => trans('sponsor.sponsor'),
            ],
            function () {
                return PersonData::all()->pluck('email_and_user_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'person_data_id', $value);
            }
        );
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminSponsorshipRequest::class);

        $this->crud->addField([
            'name' => 'cat',
            'label' => trans('cat.cat'),
            'type' => 'relationship',
            'placeholder' => 'Izberi muco',
            'attributes' => [
                'required' => 'required',
            ]
        ]);
        $this->crud->addField([
            'name' => 'personData',
            'label' => trans('sponsor.sponsor'),
            'type' => 'relationship',
            'placeholder' => 'Izberi botra',
        ]);
        $this->crud->addField(CrudFieldGenerator::moneyField([
            'name' => 'monthly_amount',
            'label' => trans('admin.sponsorship_monthly_amount'),
        ]));
        $this->crud->addField([
            'name' => 'is_anonymous',
            'label' => 'Anonimno',
            'type' => 'checkbox',
        ]);
        $this->crud->addField([
            'name' => 'is_active',
            'label' => 'Aktivno',
            'type' => 'checkbox',
        ]);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'ended_at',
            'label' => 'Datum konca',
        ]));
    }
}
