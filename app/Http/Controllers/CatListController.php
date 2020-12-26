<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
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

        $per_page = $request->input('per_page') ?: 15;
        $search = $request->input('search');
        $sponsorship_count_sort = $request->input('sponsorship_count');
        $age_sort = $request->input('age');
        $id_sort = $request->input('id');

        if ($search) {
            $cats = $cats->where('name', 'like', "%$search%");
        }

        if ($sponsorship_count_sort) {
            $cats = $cats->orderBy('sponsorships_count', $sponsorship_count_sort);
        } else if ($age_sort) {
            $cats = $cats->orderBy('date_of_birth', $age_sort === 'asc' ? 'desc' : 'asc');
        } else if ($id_sort) {
            $cats = $cats->orderBy('id', $id_sort);
        } else {
            $cats = $cats->latest('id');
        }

        $cats = $cats->paginate($per_page === 'all' ? $cats->count() : (int)$per_page);

        $cats->appends(['per_page' => $per_page === 'all' ? 'all' : (int)$per_page]);

        if ($search) {
            $cats->appends(['search' => $search]);
        }

        if ($sponsorship_count_sort) {
            $cats->appends(['sponsorship_count' => $sponsorship_count_sort]);
        } else if ($age_sort) {
            $cats->appends(['age' => $age_sort]);
        } else if ($id_sort) {
            $cats->appends(['id' => $id_sort]);
        }

        return view('cat_list', ['cats' => $cats]);
    }
}
