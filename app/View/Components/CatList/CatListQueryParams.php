<?php

namespace App\View\Components\CatList;

trait CatListQueryParams
{
    /**
     * @return array
     */
    protected function getQueryParameterArray(): array
    {
        return [
            'per_page' => request('per_page'),
            'sponsorship_count' => request('sponsorship_count'),
            'age' => request('age'),
            'id' => request('id'),
            'search' => request('search'),
        ];
    }
}
