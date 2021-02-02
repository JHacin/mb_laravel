<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\ClearsModelGlobalScopes;
use App\Http\Controllers\Admin\Traits\CrudFilterHelpers;
use App\Http\Requests\Admin\AdminSponsorshipRequest;
use App\Http\Requests\Admin\AdminSponsorshipUpdateRequest;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;

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
    use CrudFilterHelpers, ClearsModelGlobalScopes;

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
        $this->crud->addButtonFromView('line', 'sponsorship_cancel', 'sponsorship_cancel');
        $this->clearModelGlobalScopes();
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
            'type' => 'date',
        ]);
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
        $this->crud->orderBy('created_at', 'DESC');

        $this->addFilters();
    }

    /**
     * @return void
     */
    protected function addFilters()
    {
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
                return PersonData::all()->pluck('email_and_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'person_data_id', $value);
            }
        );

        $this->addBooleanFilter('is_active', 'Aktivno');
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
            ],
            'wrapper' => [
                'dusk' => 'cat-wrapper'
            ]
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
        $this->crud->addField(CrudFieldGenerator::moneyField([
            'name' => 'monthly_amount',
            'label' => trans('admin.sponsorship_monthly_amount'),
            'wrapper' => [
                'dusk' => 'monthly_amount-wrapper'
            ]
        ]));
        $this->crud->addField([
            'name' => 'is_anonymous',
            'label' => 'Anonimno',
            'type' => 'checkbox',
            'wrapper' => [
                'dusk' => 'is_anonymous-wrapper'
            ]
        ]);
        $this->crud->addField([
            'name' => 'is_active',
            'label' => 'Aktivno',
            'type' => 'checkbox',
            'wrapper' => [
                'dusk' => 'is_active-wrapper'
            ],
            'hint' =>
                'Botrovanje je v teku (redna plačila, muca še kar potrebuje botre itd.).' .
                '<br>Neaktivna botrovanja ne bodo vključena na spletni strani (v seštevkih botrovanj, na seznamih botrov itd.)',
        ]);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        $this->crud->setValidation(AdminSponsorshipUpdateRequest::class);
        $this->crud->addField(CrudFieldGenerator::dateField([
            'name' => 'ended_at',
            'label' => 'Datum konca',
            'hint' =>
                'Če želite uradno prekiniti botrovanje, je treba tudi odkljukati polje \'Aktivno\'.' .
                ' Datum konca se hrani samo za evidenco tega, koliko časa je trajalo določeno botrovanje.' .
                ' Datum se lahko izbriše s pritiskom na polje > "Clear".',
            'wrapper' => [
                'dusk' => 'ended_at-wrapper'
            ]
        ]));
    }

    /**
     * @param Sponsorship $sponsorship
     * @return RedirectResponse
     */
    public function cancelSponsorship(Sponsorship $sponsorship): RedirectResponse
    {
        $this->crud->hasAccessOrFail('update');
        if ($sponsorship->is_active) {
            $sponsorship->cancel();
            Alert::success('Botrovanje uspešno prekinjeno.')->flash();
        }
        return Redirect::back();
    }
}
