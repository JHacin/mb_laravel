<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Utilities\SponsorListViewParser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function whyBecomeSponsor(): View
    {
        return view('why-become-sponsor');
    }

    public function catDetails(Cat $cat): View
    {
        $viewData = [
            'cat' => $cat->loadMissing('sponsorships.personData'),
            'sponsors' => SponsorListViewParser::prepareViewData($cat->sponsorships),
        ];

        return view('cat_details', $viewData);
    }
}
