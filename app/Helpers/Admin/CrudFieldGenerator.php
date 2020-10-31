<?php


namespace App\Helpers\Admin;


use App\Helpers\CountryList;
use App\Helpers\SharedAttributes;
use App\Models\PersonData;
use App\Models\Sponsorship;
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
            'name' => $namePrefix . SharedAttributes::ADDRESS,
            'label' => trans('person_data.address'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . SharedAttributes::ZIP_CODE,
            'label' => trans('person_data.zip_code'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . SharedAttributes::CITY,
            'label' => trans('person_data.city'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . SharedAttributes::COUNTRY,
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
        $namePrefix = $isNested ? Sponsorship::ATTR__PERSON_DATA . '.' : '';

        $crudPanel->addField([
            'name' => $namePrefix . PersonData::ATTR__FIRST_NAME,
            'label' => trans('person_data.first_name'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . PersonData::ATTR__LAST_NAME,
            'label' => trans('person_data.last_name'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . PersonData::ATTR__GENDER,
            'label' => trans('person_data.gender'),
            'type' => 'radio',
            'options' => PersonData::GENDER_LABELS,
            'inline' => true,
            'default' => PersonData::GENDER_UNKNOWN,
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . PersonData::ATTR__PHONE,
            'label' => trans('person_data.phone'),
            'type' => 'text',
        ]);
        $crudPanel->addField([
            'name' => $namePrefix . PersonData::ATTR__DATE_OF_BIRTH,
            'label' => trans('person_data.date_of_birth'),
            'type' => 'date_picker',
            'date_picker_options' => [
                'format' => 'dd. mm. yyyy',
            ],
        ]);

        self::addAddressFields($crudPanel, $namePrefix);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function moneyField($additions = [])
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
            ]
        ], $additions);
    }
}
