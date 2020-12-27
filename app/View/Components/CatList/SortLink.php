<?php

namespace App\View\Components\CatList;

use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\View\View;

class SortLink extends Component
{
    use CatListQueryParams;

    /**
     * @var string
     */
    public string $query;

    /**
     * @var string
     */
    public string $direction;

    /**
     * @param string $query
     * @param string $direction
     */
    public function __construct(string $query, string $direction)
    {
        $this->query = $query;
        $this->direction = $direction;
    }

    /**
     * @return View|string
     */
    public function render()
    {
        $activeQueryParams = Arr::only($this->getQueryParameterArray(), ['per_page', 'search']);
        $routeParams = array_merge($activeQueryParams, [$this->query => $this->direction]);
        $isActiveSort = request($this->query) === $this->direction;

        return view('components.cat-list.sort-link', [
            'routeParams' => $routeParams,
            'isActive' => $isActiveSort || ($this->isDefaultSort() && $this->noCustomSortIsActive()),
        ]);
    }

    /**
     * @return bool
     */
    protected function isDefaultSort(): bool
    {
        return $this->query === 'id' && $this->direction === 'desc';
    }

    /**
     * @return bool
     */
    protected function noCustomSortIsActive(): bool
    {
        $params = $this->getQueryParameterArray();

        return !$params['age'] && !$params['id'] && !$params['sponsorship_count'];
    }
}
