<?php

namespace App\View\Components\CatList;

use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;

class SortLinkArrow extends Component
{
    use HasCatListQueryParams;

    public string $query;
    public string $direction;

    public function __construct(string $query, string $direction)
    {
        $this->query = $query;
        $this->direction = $direction;
    }

    public function render(): View
    {
        $queryParams = $this->getQueryParameterArray();
        $activeQueryParams = Arr::only($queryParams, ['per_page', 'search']);
        $routeParams = array_merge($activeQueryParams, [$this->query => $this->direction]);
        $isActiveSort = $queryParams[$this->query] === $this->direction;

        return view('components.cat-list.sort-link-arrow', [
            'routeParams' => $routeParams,
            'isActive' => $isActiveSort || ($this->isDefaultSort() && $this->noCustomSortIsActive()),
        ]);
    }

    protected function isDefaultSort(): bool
    {
        return $this->query === 'id' && $this->direction === 'desc';
    }

    protected function noCustomSortIsActive(): bool
    {
        $queryParams = $this->getQueryParameterArray();
        return !$queryParams['age'] && !$queryParams['id'] && !$queryParams['sponsorship_count'];
    }
}
