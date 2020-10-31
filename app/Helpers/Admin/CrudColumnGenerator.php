<?php

namespace App\Helpers\Admin;

use App\Helpers\CountryList;
use App\Helpers\SharedAttributes;
use App\Models\PersonData;

/**
 * Contains helpers for CRUD columns.
 *
 * @package App\Helpers\Admin
 */
class CrudColumnGenerator
{
    /**
     * @return string[]
     */
    public static function id()
    {
        return [
            'name' => 'id',
            'label' => trans('model.id'),
            'type' => 'number',
        ];
    }

    /**
     * @return string[]
     */
    public static function createdAt()
    {
        return [
            'name' => 'created_at',
            'label' => trans('model.created_at'),
            'type' => 'datetime',
        ];
    }

    /**
     * @return string[]
     */
    public static function updatedAt()
    {
        return [
            'name' => 'updated_at',
            'label' => trans('model.updated_at'),
            'type' => 'datetime',
        ];
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function isActive($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::IS_ACTIVE,
            'label' => trans('user.is_active'),
            'type' => 'boolean',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function address($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::ADDRESS,
            'label' => trans('person_data.address'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function zipCode($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::ZIP_CODE,
            'label' => trans('person_data.zip_code'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function city($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::CITY,
            'label' => trans('person_data.city'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function country($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::COUNTRY,
            'label' => trans('person_data.country'),
            'type' => 'select_from_array',
            'options' => CountryList::COUNTRY_NAMES,
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function firstName($additions = [])
    {
        return array_merge([
            'name' => PersonData::ATTR__FIRST_NAME,
            'label' => trans('person_data.first_name'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function lastName($additions = [])
    {
        return array_merge([
            'name' => PersonData::ATTR__LAST_NAME,
            'label' => trans('person_data.last_name'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function genderLabel($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::GENDER_LABEL,
            'label' => trans('person_data.gender'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function dateOfBirth($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::DATE_OF_BIRTH,
            'label' => trans('person_data.date_of_birth'),
            'type' => 'date',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function phone($additions = [])
    {
        return array_merge([
            'name' => PersonData::ATTR__PHONE,
            'label' => trans('person_data.phone'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function name($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::NAME,
            'label' => trans('model.name'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function email($additions = [])
    {
        return array_merge([
            'name' => SharedAttributes::EMAIL,
            'label' => trans('user.email'),
            'type' => 'text',
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function moneyColumn($additions = [])
    {
        return array_merge([
            'type' => 'number',
            'suffix' => ' €',
            'decimals' => 2,
            'dec_point' => ',',
            'thousands_sep' => '.',
        ], $additions);
    }
}
