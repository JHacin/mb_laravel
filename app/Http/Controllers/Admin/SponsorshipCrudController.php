<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnGenerator;
use App\Helpers\Admin\CrudFieldGenerator;
use App\Http\Requests\Admin\AdminSponsorshipRequest;
use App\Models\Cat;
use App\Models\Sponsorship;
use App\Models\User;
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
            'name' => 'cat',
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
    protected function getUserColumnDefinition()
    {
        return [
            'name' => 'personData',
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
            'name' => 'monthly_amount',
            'label' => trans('admin.sponsorship_monthly_amount')
        ]);
    }

    /**
     * @return string[]
     */
    protected function getIsAnonymousColumnDefinition()
    {
        return [
            'name' => 'is_anonymous',
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
        $this->crud->addColumn(self::getUserColumnDefinition());
        $this->crud->addColumn(self::getMonthlyAmountColumnDefinition());
        $this->crud->addColumn(self::getIsAnonymousColumnDefinition());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());

        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->addFilter(
            [
                'name' => 'cat_id',
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
                'name' => 'user_id',
                'type' => 'select2',
                'label' => 'Uporabnik',
            ],
            function () {
                return User::all()->pluck('email_and_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'user_id', $value);
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
        $this->crud->addColumn(self::getUserColumnDefinition());
        $this->crud->addColumn(self::getMonthlyAmountColumnDefinition());
        $this->crud->addColumn(self::getIsAnonymousColumnDefinition());
        $this->crud->addColumn(CrudColumnGenerator::createdAt());
        $this->crud->addColumn(CrudColumnGenerator::updatedAt());
    }
}
