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
use Backpack\ReviseOperation\ReviseOperation;
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
    use ReviseOperation;

    /**
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(PersonData::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsors'));
        $this->crud->setEntityNameStrings('Boter', 'Botri');
        $this->crud->addButtonFromView('line', 'sponsor_cancel_all_sponsorships', 'sponsor_cancel_all_sponsorships');
        $this->crud->enableExportButtons();
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn(CrudColumnGenerator::email());
        $this->crud->addColumn(CrudColumnGenerator::firstName());
        $this->crud->addColumn(CrudColumnGenerator::lastName());
        $this->crud->addColumn(CrudColumnGenerator::city());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn([
            'label' => 'Aktivna botrstva',
            'type' => 'relationship_count',
            'name' => 'sponsorships',
            'suffix' => ' botrstev',
            'wrapper' => [
                'dusk' => 'related-sponsorships-link',
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(
                        config('routes.admin.sponsorships') .
                        '?sponsor=' .
                        $entry->getKey() .
                        '&is_active=1'
                    );
                },
            ],
        ]);
        $this->crud->addColumn([
            'label' => 'Vsa botrstva',
            'type' => 'relationship_count',
            'name' => 'unscopedSponsorships',
            'suffix' => ' botrstev',
            'wrapper' => [
                'dusk' => 'related-unscopedSponsorships-link',
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.sponsorships') . '?sponsor=' . $entry->getKey());
                },
            ],
        ]);
    }

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

        CrudFieldGenerator::addPersonDataFields($this->crud);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /** @noinspection PhpUnused */
    public function cancelAllSponsorships(PersonData $sponsor): RedirectResponse
    {
        $this->crud->hasAccessOrFail('update');

        $sponsor->sponsorships->each(function (Sponsorship $sponsorship) {
            if ($sponsorship->is_active) {
                $sponsorship->cancel();
            }
        });

        Alert::success('Vsa aktivna botrstva so bila uspešno prekinjena.')->flash();
        return Redirect::back();
    }
}
