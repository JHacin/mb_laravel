<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnGenerator;
use App\Helpers\Admin\CrudFieldGenerator;
use App\Http\Requests\Admin\AdminSponsorshipRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;

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
    use ShowOperation;

    /**
     * @return array
     */
    protected function getCatColumnDefinition()
    {
        return [
            'name' => Sponsorship::ATTR__CAT,
            'label' => trans('cat.cat'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.cats'), [$related_key, 'show']);
                },
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getPersonDataColumnDefinition()
    {
        return [
            'name' => Sponsorship::ATTR__PERSON_DATA,
            'label' => trans('sponsor.sponsor'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    /** @var Sponsorship $entry */
                    $route = $entry->personData->belongsToRegisteredUser()
                        ? config('routes.admin.users')
                        : config('routes.admin.person_data');

                    return backpack_url($route, [$related_key, 'show']);
                },
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getMonthlyAmountColumnDefinition()
    {
        return CrudColumnGenerator::moneyColumn([
            'name' => Sponsorship::ATTR__MONTHLY_AMOUNT,
            'label' => trans('admin.sponsorship_monthly_amount')
        ]);
    }

    /**
     * @return string[]
     */
    protected function getIsAnonymousColumnDefinition()
    {
        return [
            'name' => Sponsorship::ATTR__IS_ANONYMOUS,
            'label' => 'Anonimno',
            'type' => 'boolean',
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
        $this->crud->setModel(Sponsorship::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsorships'));
        $this->crud->setEntityNameStrings('Botrovanje', 'Botrovanja');
        $this->crud->setSubheading('Dodaj novo botrovanje', 'create');
        $this->crud->setSubheading('Uredi botrovanje', 'edit');
        $this->crud->setSubheading('Podatki botrovanja', 'show');
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
        $this->crud->addColumn(self::getCatColumnDefinition());
        $this->crud->addColumn(self::getPersonDataColumnDefinition());
        $this->crud->addColumn(self::getMonthlyAmountColumnDefinition());
        $this->crud->addColumn(self::getIsAnonymousColumnDefinition());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->addFilter(
            [
                'name' => Sponsorship::ATTR__CAT,
                'type' => 'select2',
                'label' => trans('cat.cat'),
            ],
            function () {
                return Cat::all()->pluck(Cat::ATTR_NAME_AND_ID, 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', Sponsorship::ATTR__CAT_ID, $value);
            }
        );

        $this->crud->addFilter(
            [
                'name' => Sponsorship::ATTR__PERSON_DATA,
                'type' => 'select2',
                'label' => trans('sponsor.sponsor'),
            ],
            function () {
                return PersonData::all()->pluck(PersonData::ATTR__EMAIL_AND_USER_ID, 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', Sponsorship::ATTR__PERSON_DATA_ID, $value);
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
        $this->crud->setValidation(AdminSponsorshipRequest::class);

        $this->crud->addField([
            'name' => Sponsorship::ATTR__CAT,
            'label' => trans('cat.cat'),
            'type' => 'relationship',
            'placeholder' => 'Izberi muco',
            'attributes' => [
                'required' => 'required',
            ]
        ]);
        $this->crud->addField([
            'name' => Sponsorship::ATTR__PERSON_DATA,
            'label' => trans('sponsor.sponsor'),
            'type' => 'relationship',
            'placeholder' => 'Izberi botra',
        ]);
        $this->crud->addField(CrudFieldGenerator::moneyField([
            'name' => Sponsorship::ATTR__MONTHLY_AMOUNT,
            'label' => trans('admin.sponsorship_monthly_amount'),
        ]));
        $this->crud->addField([
            'name' => Sponsorship::ATTR__IS_ANONYMOUS,
            'label' => 'Botrovanje naj bo anonimno',
            'type' => 'checkbox',
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

    /**
     * Define what is displayed in the Show view.
     *
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn(self::getCatColumnDefinition());
        $this->crud->addColumn(self::getPersonDataColumnDefinition());
        $this->crud->addColumn(self::getMonthlyAmountColumnDefinition());
        $this->crud->addColumn(self::getIsAnonymousColumnDefinition());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
    }
}
