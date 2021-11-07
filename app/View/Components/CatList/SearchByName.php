<?php

namespace App\View\Components\CatList;

use Illuminate\View\Component;
use Illuminate\View\View;

class SearchByName extends Component
{
    use HasCatListQueryParams;

    public function __construct(public int $numResults)
    {
    }

    public function render(): string|View
    {
        return view('components.cat-list.search-by-name', ['activeQueryParams' => $this->getQueryParameterArray()]);
    }
}
