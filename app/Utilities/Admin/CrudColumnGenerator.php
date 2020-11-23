<?php

namespace App\Utilities\Admin;

use App\Utilities\CountryList;
use Illuminate\Database\Eloquent\Builder;

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
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $query->orWhere('id', '=', $searchTerm);
            }
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
            'name' => 'is_active',
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
            'name' => 'address',
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
            'name' => 'zip_code',
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
            'name' => 'city',
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
            'name' => 'country',
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
            'name' => 'first_name',
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
            'name' => 'last_name',
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
            'name' => 'gender_label',
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
            'name' => 'date_of_birth',
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
            'name' => 'phone',
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
            'name' => 'name',
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
            'name' => 'email',
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
