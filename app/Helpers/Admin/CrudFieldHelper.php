<?php


namespace App\Helpers\Admin;


use App\Helpers\CountryList;
use App\Models\PersonData;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class CrudFieldHelper
 * @package App\Helpers\Admin
 */
class CrudFieldHelper
{
    public static function addAddressFields(CrudPanel $crudPanel, string $namePrefix = '')
    {
        $crudPanel->addField([
            'name' => $namePrefix . 'address',
            'label' => trans('person_data.address'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'zip_code',
            'label' => trans('person_data.zip_code'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'city',
            'label' => trans('person_data.city'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'country',
            'label' => trans('person_data.country'),
            'type' => 'select2_from_array',
            'options' => CountryList::COUNTRY_NAMES,
            'allows_null' => true,
            'default' => CountryList::DEFAULT,
        ]);
    }

    /**
     * @param CrudPanel $crudPanel
     */
    public static function addPersonDataFields(CrudPanel $crudPanel)
    {
        $isNested = !($crudPanel->getModel() instanceof PersonData);
        $namePrefix = $isNested ? 'personData.' : '';

        $crudPanel->addField([
            'name' => $namePrefix . 'first_name',
            'label' => trans('person_data.first_name'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'last_name',
            'label' => trans('person_data.last_name'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'gender',
            'label' => trans('person_data.gender'),
            'type' => 'radio',
            'options' => PersonData::GENDER_LABELS,
            'inline' => true,
            'default' => PersonData::GENDER_UNKNOWN,
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'phone',
            'label' => trans('person_data.phone'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'date_of_birth',
            'label' => trans('person_data.date_of_birth'),
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);

        self::addAddressFields($crudPanel, $namePrefix);
    }
}
