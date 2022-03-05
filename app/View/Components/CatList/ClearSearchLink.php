<?php

namespace App\View\Components\CatList;

use Illuminate\View\Component;

class ClearSearchLink extends Component
{
    use HasCatListQueryParams;

    public function render()
    {
        return view('components.cat-list.clear-search-link', ['activeQueryParams' => $this->getQueryParameterArray()]);
    }
}
