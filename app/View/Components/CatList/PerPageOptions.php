<?php

namespace App\View\Components\CatList;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;

class PerPageOptions extends Component
{
    use CatListQueryParams;

    /**
     * @var LengthAwarePaginator
     */
    public LengthAwarePaginator $cats;

    /**
     * @param LengthAwarePaginator $cats
     */
    public function __construct(LengthAwarePaginator $cats)
    {
        $this->cats = $cats;
    }

    /**
     * @return View|string
     */
    public function render()
    {
        $perPageOptions = [
            15 => 15,
            30 => 30,
            'all' => 'vse',
        ];

        return view('components.cat-list.per-page-options', [
            'options' => $perPageOptions,
            'activeQueryParams' => Arr::except($this->getQueryParameterArray(), ['per_page']),
        ]);
    }
}
