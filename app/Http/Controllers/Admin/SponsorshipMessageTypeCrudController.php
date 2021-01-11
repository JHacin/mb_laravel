<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SponsorshipMessageTypeRequest;
use App\Models\SponsorshipMessageType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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

        $this->crud->addField([
            'name' => 'name',
            'label' => 'Ime',
            'type' => 'text',
            'hint' => 'Ime mora biti unikatno.',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'name-wrapper'
            ],
        ]);
        $this->crud->addField([
            'name' => 'template_id',
            'label' => 'Šifra predloge',
            'type' => 'text',
            'hint' => 'Šifra predloge v storitvi za pošiljanje mailov. Mora biti unikatna.',
            'attributes' => [
                'required' => 'required',
            ],
            'wrapper' => [
                'dusk' => 'template_id-wrapper'
            ],
        ]);
        $this->crud->addField([
            'name' => 'is_active',
            'label' => 'Aktivno',
            'type' => 'checkbox',
            'hint' => 'Če pismo ni aktivno, ne bo na voljo med možnostmi pri pošiljanju botrom.',
            'wrapper' => [
                'dusk' => 'is_active-wrapper',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
