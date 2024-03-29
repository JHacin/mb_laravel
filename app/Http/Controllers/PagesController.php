<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\News;
use App\Utilities\SponsorListViewParser;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
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
        $newsPaginator = News::paginate(10);

        return view('news', ['news' => $newsPaginator]);
    }

    public function whyBecomeSponsor(): View
    {
        return view('why-become-sponsor');
    }

    public function catDetails(Cat $cat): View
    {
        $viewData = [
            'cat' => $cat->loadMissing('sponsorships.sponsor')->loadMissing('photos'),
            'sponsors' => SponsorListViewParser::prepareViewData($cat->sponsorships),
        ];

        return view('cat-details', $viewData);
    }
}
