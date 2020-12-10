<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\CrudFilterHelpers;
use App\Http\Requests\Admin\AdminSponsorRequest;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Prologue\Alerts\Facades\Alert;

/**
 * Class SponsorCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SponsorCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use CrudFilterHelpers;

    /**
     * @return void
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(PersonData::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsors'));
        $this->crud->setEntityNameStrings('Boter', 'Botri');
        $this->crud->addButtonFromView('line', 'sponsor_cancel_all_sponsorships', 'sponsor_cancel_all_sponsorships');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn(CrudColumnGenerator::email());
        $this->crud->addColumn(CrudColumnGenerator::firstName());
        $this->crud->addColumn(CrudColumnGenerator::lastName());
        $this->crud->addColumn(CrudColumnGenerator::city());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn([
            'name' => 'is_confirmed',
            'label' => trans('person_data.is_confirmed'),
            'type' => 'boolean',
        ]);
        $this->crud->addColumn([
            'label' => 'Aktivna botrovanja',
            'type' => 'relationship_count',
            'name' => 'sponsorships',
            'suffix' => ' botrovanj',
            'wrapper' => [
                'dusk' => 'related-sponsorships-link',
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(
                        config('routes.admin.sponsorships') .
                        '?personData=' .
                        $entry->getKey() .
                        '&is_active=1'
                    );
                },
            ],
        ]);
        $this->crud->addColumn([
            'label' => 'Vsa botrovanja',
            'type' => 'relationship_count',
            'name' => 'unscopedSponsorships',
            'suffix' => ' botrovanj',
            'wrapper' => [
                'dusk' => 'related-unscopedSponsorships-link',
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.sponsorships') . '?personData=' . $entry->getKey());
                },
            ],
        ]);

        $this->addFilters();
    }

    /**
     * @return void
     */
    protected function addFilters()
    {
        $this->addBooleanFilter('is_confirmed', trans('person_data.is_confirmed'));
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminSponsorRequest::class);

        $this->crud->addField([
            'name' => 'email',
            'type' => 'email',
            'label' => trans('user.email'),
            'attributes' => [
                'required' => 'required'
            ],
            'wrapper' => [
                'dusk' => 'email-input-wrapper',
            ],
        ]);
        $this->crud->addField([
            'name' => 'is_confirmed',
            'label' => trans('person_data.is_confirmed'),
            'type' => 'checkbox',
            'hint' => 'Potrjeno je, da boter plačuje. Pri potrjenih botrih bodo na novo ustvarjena botrovanja samodejno aktivirana.',
            'wrapper' => [
                'dusk' => 'is-confirmed-input-wrapper'
            ],
        ]);
        CrudFieldGenerator::addPersonDataFields($this->crud);
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * @param PersonData $personData
     * @return RedirectResponse
     */
    public function cancelAllSponsorships(PersonData $personData): RedirectResponse
    {
        $this->crud->hasAccessOrFail('update');
        $personData->sponsorships->each(function (Sponsorship $sponsorship) {
           if ($sponsorship->is_active) {
               $sponsorship->cancel();
           }
        });
        Alert::success('Vsa aktivna botrovanja so bila uspešno prekinjena.')->flash();
        return Redirect::back();
    }
}
