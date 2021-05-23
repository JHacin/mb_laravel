<?php

namespace App\Utilities\Admin;

use App\Models\PersonData;
use App\Utilities\CountryList;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;

/**
 * Class CrudFieldHelper
 * @package App\Helpers\Admin
 */
class CrudFieldGenerator
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

    public static function addPersonDataFields(CrudPanel $crudPanel)
    {
        $isNested = !($crudPanel->getModel() instanceof PersonData);
        $namePrefix = $isNested ? 'personData.' : '';

        $crudPanel->addField([
            'name' => $namePrefix . 'first_name',
            'label' => trans('person_data.first_name'),
            'type' => 'text',
            'attributes' => [
                'required' => 'required'
            ],
            'wrapper' => [
                'dusk' => 'first_name-input-wrapper',
            ],
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'last_name',
            'label' => trans('person_data.last_name'),
            'type' => 'text',
            'attributes' => [
                'required' => 'required'
            ],
            'wrapper' => [
                'dusk' => 'last_name-input-wrapper',
            ],
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'gender',
            'label' => trans('person_data.gender'),
            'type' => 'radio',
            'options' => PersonData::GENDER_LABELS,
            'inline' => true,
            'wrapper' => [
                'dusk' => 'gender-input-wrapper',
            ],
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . 'date_of_birth',
            'label' => trans('person_data.date_of_birth'),
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
            'wrapper' => [
                'dusk' => 'date_of_birth-input-wrapper',
            ],
        ]);

        self::addAddressFields($crudPanel, $namePrefix);
    }

    public static function moneyField(array $additions = []): array
    {
        return array_merge([
            'type' => 'number',
            'prefix' => '€',
            'hint' => 'Decimalne vrednosti naj bodo ločene s piko. Dovoljeni sta največ 2 decimalki.',
            'attributes' => [
                'min' => '0.00',
                'max' => config('money.decimal_max'),
                'step' => '0.01',
                'placeholder' => '0.00'
            ],
        ], $additions);
    }

    public static function dateField(array $additions = []): array
    {
        return array_merge([
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'd. m. yyyy',
                'clearBtn' => true,
                'language' => 'sl',
                'autoclose' => true,
                'todayHighlight' => true,
            ],
        ], $additions);
    }
}
