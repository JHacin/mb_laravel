<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Admin\CrudColumnHelper;
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
            'label' => 'Muca',
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
            'label' => 'Boter',
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
        $this->crud->addColumn(CrudColumnHelper::id());
        $this->crud->addColumn(self::getCatColumnDefinition());
        $this->crud->addColumn(self::getUserColumnDefinition());
        $this->crud->addColumn(CrudColumnHelper::createdAt());
        $this->crud->addColumn(CrudColumnHelper::updatedAt());

        $this->crud->orderBy('created_at', 'DESC');

        $this->crud->addFilter(
            [
                'name' => 'cat_id',
                'type' => 'select2',
                'label' => 'Muca',
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
            'label' => 'Muca',
            'type' => 'relationship',
            'placeholder' => 'Izberi muco',
            'attributes' => [
                'required' => 'required',
            ]
        ]);
        $this->crud->addField([
            'name' => 'personData',
            'label' => 'Boter',
            'type' => 'relationship',
            'placeholder' => 'Izberi botra',
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

        $this->crud->addColumn(CrudColumnHelper::id());
        $this->crud->addColumn(self::getCatColumnDefinition());
        $this->crud->addColumn(self::getUserColumnDefinition());
        $this->crud->addColumn(CrudColumnHelper::createdAt());
        $this->crud->addColumn(CrudColumnHelper::updatedAt());
    }
}
