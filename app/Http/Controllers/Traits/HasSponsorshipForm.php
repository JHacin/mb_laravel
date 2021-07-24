<?php

namespace App\Http\Controllers\Traits;

use App\Models\PersonData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

trait HasSponsorshipForm
{
    protected function getPayerFromFormData(FormRequest $request): PersonData
    {
        return $this->updateOrCreatePersonData($request->input('personData'));
    }

    protected function getGifteeFromFormData(FormRequest $request): ?PersonData
    {
        if ($request->input('is_gift') === 'yes') {
            return $this->updateOrCreatePersonData($request->input('giftee'));
        }

        return null;
    }

    protected function successRedirect(): RedirectResponse
    {
        return back()->with(
            'success_message',
            'Hvala! Na email naslov smo vam poslali navodila za zaključek postopka.'
        );
    }

    private function updateOrCreatePersonData(array $personDataFormInput): PersonData
    {
        $existingWithSameData = $this->findPersonWithSameNameAndEmail($personDataFormInput);

        if ($existingWithSameData instanceof PersonData) {
            $existingWithSameData->update($personDataFormInput);
            $existingWithSameData->refresh();
            return $existingWithSameData;
        }

        return PersonData::create($personDataFormInput);
    }

    private function findPersonWithSameNameAndEmail(array $personDataFormInput): ?PersonData
    {
        return PersonData::where(['email' => $personDataFormInput['email']])
            ->whereRaw("UPPER(first_name) = '" . strtoupper($personDataFormInput['first_name']) . "'")
            ->whereRaw("UPPER(last_name) = '" . strtoupper($personDataFormInput['last_name']) . "'")
            ->get()
            ->first();
    }
}
