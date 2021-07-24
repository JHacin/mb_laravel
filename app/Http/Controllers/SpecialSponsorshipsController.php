<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasSponsorshipForm;
use App\Http\Requests\SpecialSponsorshipRequest;
use App\Models\SpecialSponsorship;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SpecialSponsorshipsController extends Controller
{
    use HasSponsorshipForm;

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
        $hasInvalidType = !$type || !in_array($type, SpecialSponsorship::TYPES);

        if ($hasInvalidType) {
            $type = SpecialSponsorship::TYPE_BOTER_MESECA;
        }

        return $type;
    }

    public function submit(SpecialSponsorshipRequest $request): RedirectResponse
    {
        $payer = $this->getPayer($request);
        $giftee = $this->getGiftee($request);

        // Todo: create + gift

        // Todo: mail

        return $this->successRedirect();
    }

    public function archive(): View
    {
        return view('special-sponsorships-archive');
    }
}
