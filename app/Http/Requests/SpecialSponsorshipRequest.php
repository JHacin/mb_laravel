<?php

namespace App\Http\Requests;

use App\Models\PersonData;
use App\Models\SpecialSponsorship;
use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpecialSponsorshipRequest extends FormRequest
{
    public function rules(): array
    {
        $requiredIfGift = 'required_if:is_gift,yes';

        return [
            'personData.email' => ['required', 'string', 'email'],
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
            ],
            'giftee.first_name' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.last_name' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.gender' => [$requiredIfGift, 'nullable', Rule::in(PersonData::GENDERS)],
            'giftee.address' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.zip_code' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.city' => [$requiredIfGift, 'nullable', 'string', 'max:255'],
            'giftee.country' => [$requiredIfGift, 'nullable', new CountryCode],
            'is_anonymous' => ['boolean'],
            'is_gift' => [Rule::in(['yes', 'no'])],
            'is_agreed_to_terms' => ['accepted'],
            'amount' => ['required', 'numeric', 'min:' . SpecialSponsorship::TYPE_AMOUNTS[$this->input('type')]],
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [
            'personData.email.not_in' =>
                'Muca že ima aktivnega botra s tem email naslovom.' .
                ' Če menite, da je prišlo do napake, nas prosim kontaktirajte na boter@macjahisa.si.',
            'giftee.email.not_in' =>
                'Muca že ima aktivnega botra s tem email naslovom.' .
                ' Če menite, da je prišlo do napake, nas prosim kontaktirajte na boter@macjahisa.si.',
            'amount.min' => 'Znesek mora biti vsaj :min €.'
        ];
    }
}
