<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatSponsorshipRequest;
use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use SponsorshipMail;

class CatSponsorshipController extends Controller
{
    public function submit(Cat $cat, CatSponsorshipRequest $request): RedirectResponse
    {
        $input = $request->all();

        if (Auth::check()) {
            $this->updateUserEmail(Auth::user(), $input['personData']['email']);
        }

        $personData = $this->updateOrCreatePersonData($request->input('personData'));
        $sponsorship = $this->createSponsorship($cat, $personData, $input);
        SponsorshipMail::sendInitialInstructionsEmail($sponsorship);

        return back()->with(
            'success_message',
            'Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.'
        );
    }

    protected function updateUserEmail(User $user, string $inputEmail)
    {
        if ($inputEmail === $user->email) {
            return;
        }

        $user->update(['email' => $inputEmail]);
    }

    protected function updateOrCreatePersonData(array $personDataFormInput): PersonData
    {
        $personData = PersonData::firstOrCreate(['email' => $personDataFormInput['email']]);
        $personData->update($personDataFormInput);
        $personData->refresh();

        return $personData;
    }

    protected function createSponsorship(Cat $cat, PersonData $personData, array $formInput): Sponsorship
    {
        return Sponsorship::create([
            'person_data_id' => $personData->id,
            'cat_id' => $cat->id,
            'monthly_amount' => $formInput['monthly_amount'],
            'payment_type' => isset($formInput['wants_direct_debit'])
                ? Sponsorship::PAYMENT_TYPE_DIRECT_DEBIT
                : Sponsorship::PAYMENT_TYPE_BANK_TRANSFER,
            'is_anonymous' => $formInput['is_anonymous'] ?? false,
            'is_active' => false,
        ]);
    }

    public function form(Cat $cat): View
    {
        return view('become-cat-sponsor', ['cat' => $cat]);
    }
}
