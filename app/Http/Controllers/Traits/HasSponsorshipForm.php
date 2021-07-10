<?php

namespace App\Http\Controllers\Traits;

use App\Models\PersonData;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

trait HasSponsorshipForm
{
    protected function getPayer(FormRequest $request): PersonData
    {
        return $this->updateOrCreatePersonData($request->input('personData'));
    }

    protected function getGiftee(FormRequest $request): ?PersonData
    {
        return $request->input('is_gift') === 'yes'
            ? $this->updateOrCreatePersonData($request->input('giftee'))
            : null;
    }

    protected function updateUserIfLoggedIn(FormRequest $request): void
    {
        if (Auth::check()) {
            $this->updateUserEmail(Auth::user(), $request->input('personData.email'));
        }
    }

    protected function successRedirect(): RedirectResponse
    {
        return back()->with('success_message', 'Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.');
    }

    private function updateUserEmail(User $user, string $inputEmail): void
    {
        if ($inputEmail === $user->email) {
            return;
        }

        $user->update(['email' => $inputEmail]);
    }

    private function updateOrCreatePersonData(array $personDataFormInput): PersonData
    {
        $personData = PersonData::firstOrCreate(['email' => $personDataFormInput['email']]);
        $personData->update($personDataFormInput);
        $personData->refresh();

        return $personData;
    }
}
