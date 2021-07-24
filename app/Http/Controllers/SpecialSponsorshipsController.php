<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasSponsorshipForm;
use App\Http\Requests\SpecialSponsorshipRequest;
use App\Models\PersonData;
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
        $payer = $this->getPayerFromFormData($request);
        $giftee = $this->getGifteeFromFormData($request);

        $sponsorship = $this->createSponsorship($payer, $giftee, $request->all());

        // Todo: mail

        return $this->successRedirect();
    }

    protected function createSponsorship(
        PersonData $payer,
        ?PersonData $giftee,
        array $formInput
    ): SpecialSponsorship {
        $isGift = $giftee instanceof PersonData;

        $params = [
            'type' => $formInput['type'],
            'sponsor_id' => $isGift ? $giftee->id : $payer->id,
            'payer_id' => $isGift ? $payer->id : null,
            'is_gift' => $isGift,
            'is_anonymous' => $formInput['is_anonymous'] ?? false,
        ];

        return SpecialSponsorship::create($params);
    }

    public function archive(): View
    {
        return view('special-sponsorships-archive');
    }
}
