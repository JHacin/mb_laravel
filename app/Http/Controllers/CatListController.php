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
        $per_page = $request->input('per_page') ? (int)$request->input('per_page') : 15;
        $sponsorship_count_sort = $request->input('sponsorship_count');

        $cats = Cat::withCount('sponsorships');

        if ($sponsorship_count_sort) {
            $cats = $cats->orderBy('sponsorships_count', $sponsorship_count_sort);
        } else {
            $cats = $cats->latest('id');
        }

        $cats = $cats->paginate($per_page);

        $cats->appends(['per_page' => $per_page]);

        if ($sponsorship_count_sort) {
            $cats->appends(['sponsorship_count' => $sponsorship_count_sort]);
        }

        return view('cat_list', ['cats' => $cats]);
    }
}
