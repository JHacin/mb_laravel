<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasSponsorshipForm;
use App\Http\Requests\CatSponsorshipRequest;
use App\Mail\SponsorshipMail;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CatSponsorshipController extends Controller
{
    use HasSponsorshipForm;

    private SponsorshipMail $sponsorshipMail;

    public function __construct(SponsorshipMail $sponsorshipMail)
    {
        $this->sponsorshipMail = $sponsorshipMail;
    }

    public function submit(Cat $cat, CatSponsorshipRequest $request): RedirectResponse
    {
        $this->validateCatStatus($cat);

        $payer = $this->getPayerFromFormData($request);
        $giftee = $this->getGifteeFromFormData($request);

        $sponsorship = $this->createSponsorship($cat, $payer, $giftee, $request->all());

        $this->sponsorshipMail->sendInitialInstructionsEmail($sponsorship);

        return $this->successRedirect();
    }

    protected function createSponsorship(
        Cat $cat,
        PersonData $payer,
        ?PersonData $giftee,
        array $formInput
    ): Sponsorship {
        $isGift = $giftee instanceof PersonData;

        $params = [
            'sponsor_id' => $isGift ? $giftee->id : $payer->id,
            'payer_id' => $isGift ? $payer->id : null,
            'cat_id' => $cat->id,
            'monthly_amount' => $formInput['monthly_amount'],
            'payment_type' => isset($formInput['wants_direct_debit'])
                ? Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT
                : Sponsorship::PAYMENT_TYPE_BANK_TRANSFER,
            'is_gift' => $isGift,
            'is_anonymous' => $formInput['is_anonymous'] ?? false,
            'is_active' => false,
        ];

        return Sponsorship::create($params);
    }

    public function form(Cat $cat): View
    {
        $this->validateCatStatus($cat);

        return view('become-cat-sponsor', ['cat' => $cat]);
    }

    protected function validateCatStatus(Cat $cat)
    {
        if ($cat->status !== Cat::STATUS_SEEKING_SPONSORS) {
            abort(403);
        }
    }
}
