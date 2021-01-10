<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Utilities\SponsorListViewParser;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function faq(): View
    {
        return view('faq');
    }

    public function privacy(): View
    {
        return view('privacy');
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
