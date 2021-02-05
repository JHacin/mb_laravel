<?php

namespace App\Http\Requests;

use App\Models\Cat;
use App\Models\PersonData;
use App\Rules\CountryCode;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CatSponsorshipRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'personData.email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
                Rule::notIn($this->getCatSponsorEmails()),
            ],
            'personData.first_name' => ['nullable', 'string', 'max:255'],
            'personData.last_name' => ['nullable', 'string', 'max:255'],
            'personData.gender' => ['required', Rule::in(PersonData::GENDERS)],
            'personData.address' => ['required', 'string', 'max:255'],
            'personData.zip_code' => ['required', 'string', 'max:255'],
            'personData.city' => ['required', 'string', 'max:255'],
            'personData.country' => ['required', new CountryCode],
            'monthly_amount' => [
                'required',
                'numeric',
                'min:' . config('money.donation_minimum'),
                'max:' . config('money.decimal_max'),
            ],
            'is_anonymous' => ['boolean'],
            'is_agreed_to_terms' => ['accepted'],
            'wants_direct_debit' => ['boolean'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [
            'personData.email.unique' =>
                'Ta email naslov že uporablja registriran uporabnik.' .
                ' Če je email naslov vaš in ga želite uporabiti, se prosimo najprej prijavite v račun.',
            'personData.email.not_in' =>
                'Muca že ima aktivnega botra s tem email naslovom.' .
                ' Če menite, da je prišlo do napake, nas prosim kontaktirajte na boter@macjahisa.si.'
        ];
    }

    protected function getCatSponsorEmails(): array
    {
        /** @var Cat $cat */
        $cat = $this->route()->parameter('cat');

        $catSponsorships = $cat
            ->sponsorships()
            ->with('personData')
            ->get()
            ->toArray();

        return Arr::pluck($catSponsorships, 'person_data.email');
    }
}
