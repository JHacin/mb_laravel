<?php

namespace App\View\Components\CatList;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class SortLinkToggle extends Component
{
    use HasCatListQueryParams;

    public string $label;
    public string $query;

    public function __construct(string $label, string $query)
    {
        $this->label = $label;
        $this->query = $query;
    }

    public function render(): View
    {
        $queryParams = $this->getQueryParameterArray();
        $activeQueryParams = Arr::only($queryParams, ['per_page', 'search']);
        $direction = $queryParams[$this->query] === 'asc' ? 'desc' : 'asc';
        $routeParams = array_merge($activeQueryParams, [$this->query => $direction]);
        $isActiveSort = $queryParams[$this->query] !== null;

        return view('components.cat-list.sort-link-toggle', [
            'routeParams' => $routeParams,
            'isActive' => $isActiveSort,
        ]);
    }
}
