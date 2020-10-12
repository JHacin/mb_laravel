<?php

namespace App\Helpers\Admin;

use App\Helpers\CountryList;

/**
 * Contains helpers for CRUD columns.
 *
 * @package App\Helpers\Admin
 */
class CrudColumnHelper
{
    public const ID_COLUMN_DEFINITION = [
        'name' => 'id',
        'label' => 'Šifra',
        'type' => 'number',
    ];

    public const CREATED_AT_COLUMN_DEFINITION = [
        'name' => 'created_at',
        'label' => 'Datum vnosa',
        'type' => 'datetime',
    ];

    public const UPDATED_AT_COLUMN_DEFINITION = [
        'name' => 'updated_at',
        'label' => 'Zadnja sprememba',
        'type' => 'datetime',
    ];

    public const ADDRESS_COLUMN_DEFINITION = [
        'name' => 'address',
        'label' => 'Naslov',
        'type' => 'text',
    ];

    public const ZIP_CODE_COLUMN_DEFINITION = [
        'name' => 'zip_code',
        'label' => 'Poštna številka',
        'type' => 'text',
    ];

    public const CITY_COLUMN_DEFINITION = [
        'name' => 'city',
        'label' => 'Kraj',
        'type' => 'text',
    ];

    public const COUNTRY_COLUMN_DEFINITION = [
        'name' => 'country',
        'label' => 'Država',
        'type' => 'select_from_array',
        'options' => CountryList::COUNTRY_NAMES,
    ];
}
