<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SponsorshipMessageTypeRequest;
use App\Models\SponsorshipMessageType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Exception;

/**
 * Class SponsorshipMessageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SponsorshipMessageTypeCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    /**
     * @throws Exception
     */
    public function setup()
    {
        $this->crud->setModel(SponsorshipMessageType::class);
        $this->crud->setRoute(
            config('backpack.base.route_prefix') . '/' . config('routes.admin.sponsorship_message_types')
        );
        $this->crud->setEntityNameStrings('Vrsta pisma', 'Vrste pisem');
    }

    protected function setupListOperation()
    {
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(SponsorshipMessageTypeRequest::class);
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
