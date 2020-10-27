<?php

namespace App\Http\Controllers;

use App\Helpers\SponsorList;
use App\Models\Cat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
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
        $cats = Cat::withCount('sponsorships')->get();

        return view('cat_list', ['cats' => $cats]);
    }

    /**
     * Show the cat details page.
     *
     * @param Cat $cat
     * @return Application|Factory|View|void
     */
    public function catDetails(Cat $cat)
    {
        $viewData = [
            'cat' => $cat,
            'sponsors' => SponsorList::prepareViewData($cat->sponsorships),
        ];

        return view('cat_details', $viewData);
    }

    /**
     * Show the page with the form for sponsoring a cat.
     *
     * @param Cat $cat
     * @return Application|Factory|View|void
     */
    public function becomeCatSponsor(Cat $cat)
    {
        return view('become_cat_sponsor', ['cat' => $cat]);
    }

}
