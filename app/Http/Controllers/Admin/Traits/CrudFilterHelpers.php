<?php

namespace App\Http\Controllers\Admin\Traits;

trait CrudFilterHelpers
{
    public function addBooleanFilter(string $fieldName, string $label)
    {
        $options = [true => 'Da', false => 'Ne'];
        $this->addDropdownFilter($fieldName, $label, $options);
    }

    public function addDropdownFilter(string $fieldName, string $label, array $options)
    {
        $this->crud->addFilter(
            [
                'name' => $fieldName,
                'type' => 'dropdown',
                'label' => $label,
            ],
            $options,
            function ($value) use ($fieldName) {
                $this->crud->addClause('where', $fieldName, $value);
            }
        );
    }
}
