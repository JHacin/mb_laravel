<?php

namespace App\View\Components\CatList;

use App\Models\Cat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;

class PerPageOptions extends Component
{
    use HasCatListQueryParams;

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
        $perPageOptions = [];

        foreach (Cat::PER_PAGE_OPTIONS as $option) {
            $label = $option === Cat::PER_PAGE_ALL ? 'vse' : $option;
            $perPageOptions[$option] = $label;
        }

        return view('components.cat-list.per-page-options', [
            'options' => $perPageOptions,
            'activeQueryParams' => Arr::except($this->getQueryParameterArray(), ['per_page']),
        ]);
    }
}
