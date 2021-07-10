<?php

namespace App\Http\Controllers;

use App\Models\SpecialSponsorship;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SpecialSponsorshipsController extends Controller
{
    public function index(): View
    {
        return view('special-sponsorships');
    }

    public function form(Request $request): View
    {
        $sponsorshipType = $this->getValidSponsorshipType($request);

        return view('special-sponsorships-form', ['sponsorship_type' => $sponsorshipType]);
    }

    protected function getValidSponsorshipType(Request $request): int
    {
        $type = (int)$request->query('tip');

        if (!$type || !in_array($type, SpecialSponsorship::TYPES)) {
            $type = SpecialSponsorship::TYPE_BOTER_MESECA;
        }

        return $type;
    }

    public function archive(): View
    {
        return view('special-sponsorships-archive');
    }
}
