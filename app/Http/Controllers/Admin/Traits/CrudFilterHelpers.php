<?php

namespace App\Http\Controllers\Admin\Traits;

trait CrudFilterHelpers
{
    /**
     * @param string $field
     * @param string $label
     */
    public function addBooleanFilter(string $field, string $label)
    {
        $this->crud->addFilter(
            [
                'name' => $field,
                'type' => 'dropdown',
                'label' => $label,
            ],
            [
                true => 'Da',
                false => 'Ne'
            ],
            function ($value) use ($field) {
                $this->crud->addClause('where', $field, $value);
            }
        );
    }
}
