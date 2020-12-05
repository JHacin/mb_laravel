<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Utilities\SponsorListViewParser;
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
     * Show the cat details page.
     *
     * @param Cat $cat
     * @return Application|Factory|View|void
     */
    public function catDetails(Cat $cat)
    {
        $viewData = [
            'cat' => $cat->loadMissing('sponsorships.personData'),
            'sponsors' => SponsorListViewParser::prepareViewData($cat->sponsorships),
        ];

        return view('cat_details', $viewData);
    }
}
