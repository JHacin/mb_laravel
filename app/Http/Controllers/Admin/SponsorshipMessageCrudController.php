<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminSponsorshipMessageRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\SponsorshipMessage;
use App\Models\SponsorshipMessageType;
use App\Utilities\Admin\CrudColumnGenerator;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use SponsorshipMessageHandler;

/**
 * Class SponsorshipMessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SponsorshipMessageCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation { store as traitStore; }

    /**
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(SponsorshipMessage::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsorship_messages'));
        $this->crud->setEntityNameStrings('Pismo', 'Pisma');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn(CrudColumnGenerator::id());
        $this->crud->addColumn([
            'name' => 'messageType',
            'label' => trans('sponsorship_message.message_type'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.sponsorship_message_types'), [$related_key, 'edit']);
                },
            ],
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('messageType', function (Builder $query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
                });
            }
        ]);
        $this->crud->addColumn([
            'name' => 'personData',
            'label' => trans('sponsorship_message.person_data'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.sponsors'), [$related_key, 'edit']);
                },
            ],
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('personData', function (Builder $query) use ($searchTerm) {
                    $query->where('email', 'like', "%$searchTerm%");
                });
            }
        ]);
        $this->crud->addColumn([
            'name' => 'cat',
            'label' => trans('sponsorship_message.cat'),
            'type' => 'relationship',
            'wrapper' => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url(config('routes.admin.cats'), [$related_key, 'edit']);
                },
            ],
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhereHas('cat', function (Builder $query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%");
                });
            }
        ]);

        $this->addFilters();
    }
    protected function addFilters()
    {
        $this->crud->addFilter(
            [
                'name' => 'messageType',
                'type' => 'select2',
                'label' => trans('sponsorship_message.message_type'),
            ],
            function () {
                return SponsorshipMessageType::all()->pluck('name', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'message_type_id', $value);
            }
        );
        $this->crud->addFilter(
            [
                'name' => 'personData',
                'type' => 'select2',
                'label' => trans('sponsorship_message.person_data'),
            ],
            function () {
                return PersonData::all()->pluck('email_and_user_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'person_data_id', $value);
            }
        );
        $this->crud->addFilter(
            [
                'name' => 'cat',
                'type' => 'select2',
                'label' => trans('sponsorship_message.cat'),
            ],
            function () {
                return Cat::all()->pluck('name_and_id', 'id')->toArray();
            },
            function ($value) {
                $this->crud->addClause('where', 'cat_id', $value);
            }
        );
    }


    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AdminSponsorshipMessageRequest::class);

        $this->crud->addField([
            'name' => 'messageType',
            'label' => trans('sponsorship_message.message_type'),
            'type' => 'relationship',
            'options' => function (Builder $query) {
                return $query->where('is_active', true)->get();
            },
            'placeholder' => 'Izberi vrsto pisma',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'messageType-wrapper'
            ]
        ]);

        $this->crud->addField([
            'name' => 'personData',
            'label' => trans('sponsorship_message.person_data'),
            'type' => 'relationship',
            'placeholder' => 'Izberi botra',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'personData-wrapper'
            ]
        ]);

        $this->crud->addField([
            'name' => 'cat',
            'label' => trans('sponsorship_message.cat'),
            'type' => 'relationship',
            'placeholder' => 'Izberi muco',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'cat-wrapper'
            ]
        ]);
    }

    public function store(): RedirectResponse
    {
        $response = $this->traitStore();

        /** @var SponsorshipMessage $msg */
        $msg = $this->crud->getCurrentEntry();

        SponsorshipMessageHandler::send($msg);

        return $response;
    }
}
