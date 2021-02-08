<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Utilities\SponsorListViewParser;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function index(): View
    {
        $heroCats = Cat::inRandomOrder()->get()->slice(0, 3);

        return view('home', ['heroCats' => $heroCats]);
    }

    public function faq(): View
    {
        return view('faq');
    }

    public function privacy(): View
    {
        return view('privacy');
    }

    public function news(): View
    {
        return view('news');
    }

    public function whyBecomeSponsor(): View
    {
        return view('why-become-sponsor');
    }

    public function catDetails(Cat $cat): View
    {
        $viewData = [
            'cat' => $cat->loadMissing('sponsorships.personData')->loadMissing('photos'),
            'sponsors' => SponsorListViewParser::prepareViewData($cat->sponsorships),
        ];

        return view('cat-details', $viewData);
    }
}
