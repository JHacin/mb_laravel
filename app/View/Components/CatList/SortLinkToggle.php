<?php

namespace App\View\Components\CatList;

use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;

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
            'isActive' => $isActiveSort || ($this->isDefaultSort() && $this->noCustomSortIsActive()),
        ]);
    }

    protected function isDefaultSort(): bool
    {
        return $this->query === 'id';
    }

    protected function noCustomSortIsActive(): bool
    {
        $queryParams = $this->getQueryParameterArray();
        return !$queryParams['age'] && !$queryParams['id'] && !$queryParams['sponsorship_count'];
    }
}
