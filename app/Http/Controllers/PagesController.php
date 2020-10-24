<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PagesController extends Controller
{

    /**
     * Show the homepage.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the cat list.
     *
     * @return Application|Factory|View
     */
    public function catList()
    {
        $cats = Cat::all();

        return view('cat_list', ['cats' => $cats]);
    }

    /**
     * Show the cat details page.
     *
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function catDetails(Request $request)
    {
        $id = $request->route()->parameter('id');

        $cat = Cat::find($id);

        if (!$cat) {
            return abort(404);
        }

        return view('cat_details', ['cat' => $cat]);
    }

    /**
     * Show the page with the form for sponsoring a cat.
     *
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function becomeCatSponsor(Request $request)
    {
        $id = $request->route()->parameter('id');

        $cat = Cat::find($id);

        if (!$cat) {
            return abort(404);
        }

        return view('become_cat_sponsor', ['cat' => $cat]);
    }

}
