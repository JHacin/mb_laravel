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
    public static function id(): array
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

    public static function createdAt($additions = []): array
    {
        return array_merge([
            'name' => 'created_at',
            'label' => trans('model.created_at'),
            'type' => 'datetime',
        ], $additions);
    }

    /**
     * @return string[]
     */
    public static function updatedAt(): array
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
    public static function isActive($additions = []): array
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
    public static function address($additions = []): array
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
    public static function zipCode($additions = []): array
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
    public static function city($additions = []): array
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
    public static function country($additions = []): array
    {
        return array_merge([
            'name' => 'country',
            'label' => trans('person_data.country'),
            'type' => 'select_from_array',
            'options' => CountryList::COUNTRY_NAMES,
            'searchLogic' => function (Builder $query, $column, $searchTerm) {
                $code = CountryList::getCodeByName($searchTerm);
                if (!$code) {
                    return false;
                }
                return $query->orWhere('country', $code);
            }
        ], $additions);
    }

    /**
     * @param array $additions
     * @return array
     */
    public static function firstName($additions = []): array
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
    public static function lastName($additions = []): array
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
    public static function genderLabel($additions = []): array
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
    public static function dateOfBirth($additions = []): array
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
    public static function phone($additions = []): array
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
    public static function name($additions = []): array
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
    public static function email($additions = []): array
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
    public static function moneyColumn($additions = []): array
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
