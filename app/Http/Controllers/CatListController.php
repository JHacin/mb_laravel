<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatListController extends Controller
{
    /**
     * Show the cat list.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $cats = Cat::withCount('sponsorships');

        $params = $request->all([
            'per_page',
            'search',
            'sponsorship_count',
            'age',
            'id'
        ]);

        if (!$params['per_page']) {
            $params['per_page'] = Cat::PER_PAGE_DEFAULT;
        }

        $cats = $this->addWhereClauses($cats, $params);
        $cats = $this->addOrderByClause($cats, $params);
        $cats = $this->addPagination($cats, $params);
        $this->addPaginationLinkAdditions($cats, $params);

        return view('cat-list', ['cats' => $cats]);
    }

    /**
     * @param Builder $cats
     * @param array $params
     * @return Builder
     */
    protected function addWhereClauses(Builder $cats, array $params): Builder
    {
        $searchByName = $params['search'];
        if ($searchByName) {
            $cats = $cats->where('name', 'like', "%$searchByName%");
        }

        return $cats;
    }

    /**
     * @param Builder $cats
     * @param array $params
     * @return Builder
     */
    protected function addOrderByClause(Builder $cats, array $params): Builder
    {
        if ($params['sponsorship_count']) {
            return $cats->orderBy('sponsorships_count', $params['sponsorship_count']);
        }

        if ($params['age']) {
            $direction = $params['age'] === 'asc' ? 'DESC' : 'ASC';
            return $cats->orderByRaw("ISNULL(date_of_birth), date_of_birth $direction");
        }

        if ($params['id']) {
            return $cats->orderBy('id', $params['id']);
        }

        return $cats
            ->orderBy('is_group', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * @param Builder $cats
     * @param array $params
     * @return LengthAwarePaginator
     */
    protected function addPagination(Builder $cats, array $params): LengthAwarePaginator
    {
        $perPage = $params['per_page'] === 'all'
            ? $cats->count()
            : (int)$params['per_page'];

        $cats = $cats->paginate($perPage);

        return $cats;
    }

    /**
     * @param LengthAwarePaginator $cats
     * @param array $params
     */
    protected function addPaginationLinkAdditions(LengthAwarePaginator $cats, array $params)
    {
        $cats->appends([
            'per_page' =>
                $params['per_page'] === 'all'
                    ? 'all'
                    : (int)$params['per_page']
        ]);

        foreach (['search', 'sponsorship_count', 'age', 'id'] as $query) {
            if ($params[$query]) {
                $cats->appends([$query => $params[$query]]);
            }
        }
    }
}
