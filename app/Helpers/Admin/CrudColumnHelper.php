<?php

namespace App\Helpers\Admin;

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
}
