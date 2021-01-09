<?php

namespace App\View\Components\CatList;

use Illuminate\View\Component;
use Illuminate\View\View;

class SearchByName extends Component
{
    use HasCatListQueryParams;

    /**
     * @return View|string
     */
    public function render()
    {
        return view('components.cat-list.search-by-name', ['activeQueryParams' => $this->getQueryParameterArray()]);
    }
}
