<?php

namespace App\Http\Controllers;

use App\Models\SpecialSponsorship;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SpecialSponsorshipsController extends Controller
{
    public function index(): View
    {
        return view('special-sponsorships');
    }

    public function form(Request $request): View
    {
        $selectedType = $this->getValidSponsorshipType($request);

        return view('special-sponsorships-form', ['selectedType' => $selectedType]);
    }

    protected function getValidSponsorshipType(Request $request): int
    {
        $type = (int)$request->query('tip');

        if (!$type || !in_array($type, SpecialSponsorship::TYPES)) {
            $type = SpecialSponsorship::TYPE_BOTER_MESECA;
        }

        return $type;
    }

    public function submit(): RedirectResponse
    {
        return back()->with('success_message', 'Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
    }

    public function archive(): View
    {
        return view('special-sponsorships-archive');
    }
}
