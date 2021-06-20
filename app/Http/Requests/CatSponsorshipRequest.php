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
    public function rules(): array
    {
        $requiredIfGift = 'required_if:is_gift,yes';

        return [
            'personData.email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
                Rule::notIn($this->getCatSponsorEmails()),
            ],
            'personData.first_name' => ['required', 'string', 'max:255'],
            'personData.last_name' => ['required', 'string', 'max:255'],
            'personData.gender' => ['required', Rule::in(PersonData::GENDERS)],
            'personData.address' => ['required', 'string', 'max:255'],
            'personData.zip_code' => ['required', 'string', 'max:255'],
            'personData.city' => ['required', 'string', 'max:255'],
            'personData.country' => ['required', new CountryCode],
            'giftee.email' => [
                $requiredIfGift,
                'nullable',
                'string',
                'email',
                Rule::notIn($this->getCatSponsorEmails()),
            ],
            'giftee.first_name' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.last_name' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.gender' => [$requiredIfGift, 'nullable', Rule::in(PersonData::GENDERS)],
            'giftee.address' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.zip_code' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.city' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.country' => [$requiredIfGift, 'nullable', new CountryCode],
            'monthly_amount' => [
                'required',
                'numeric',
                'min:' . config('money.donation_minimum'),
                'max:' . config('money.decimal_max'),
            ],
            'is_anonymous' => ['boolean'],
            'is_gift' => [Rule::in(['yes', 'no'])],
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
                ' Če menite, da je prišlo do napake, nas prosim kontaktirajte na boter@macjahisa.si.',
            'giftee.email.unique' =>
                'Ta email naslov že uporablja registriran uporabnik.' .
                ' Če je email naslov vaš in ga želite uporabiti, se prosimo najprej prijavite v račun.',
            'giftee.email.not_in' =>
                'Muca že ima aktivnega botra s tem email naslovom.' .
                ' Če menite, da je prišlo do napake, nas prosim kontaktirajte na boter@macjahisa.si.'
        ];
    }

    protected function getCatSponsorEmails(): array
    {
        /** @var Cat $cat */
        $cat = $this->route()->parameter('cat');

        $activeSponsorships = $cat
            ->sponsorships()
            ->with('personData')
            ->get()
            ->toArray();

        return Arr::pluck($activeSponsorships, 'person_data.email');
    }
}
