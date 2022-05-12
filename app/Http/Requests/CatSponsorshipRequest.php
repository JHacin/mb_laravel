<?php

namespace App\Http\Requests;

use App\Models\Cat;
use App\Models\PersonData;
use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CatSponsorshipRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'payer_email' => [
                'required',
                'string',
                'email',
                Rule::notIn($this->getCatSponsorEmails()),
            ],
            'payer_first_name' => ['required', 'string', 'max:255'],
            'payer_last_name' => ['required', 'string', 'max:255'],
            'payer_gender' => ['required', Rule::in(PersonData::GENDERS)],
            'payer_address' => ['required', 'string', 'max:255'],
            'payer_zip_code' => ['required', 'string', 'max:255'],
            'payer_city' => ['required', 'string', 'max:255'],
            'payer_country' => ['required', new CountryCode],
            'monthly_amount' => [
                'required',
                'numeric',
                'min:' . config('money.donation_minimum'),
                'max:' . config('money.decimal_max'),
            ],
            'is_anonymous' => ['boolean'],
            'is_gift' => ['boolean'],
            'is_agreed_to_terms' => ['accepted'],
            'wants_direct_debit' => ['boolean'],
        ];

        if ($this->get('is_gift')) {
            $gifteeRules = [
                'giftee_email' => [
                    'required',
                    'nullable',
                    'string',
                    'email',
                    Rule::notIn($this->getCatSponsorEmails()),
                ],
                'giftee_first_name' => ['required', 'string', 'max:255'],
                'giftee_last_name' => ['required', 'string', 'max:255'],
                'giftee_gender' => ['required', Rule::in(PersonData::GENDERS)],
                'giftee_address' => ['required', 'string', 'max:255'],
                'giftee_zip_code' => ['required', 'string', 'max:255'],
                'giftee_city' => ['required', 'string', 'max:255'],
                'giftee_country' => ['required', new CountryCode],
            ];

            $rules = array_merge($rules, $gifteeRules);
        }

        return $rules;
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [
            'payer_email.not_in' =>
            'Muca že ima aktivnega botra s tem email naslovom.' .
                ' Če menite, da je prišlo do napake, nas prosim kontaktirajte na boter@macjahisa.si.',
            'giftee_email.not_in' =>
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
            ->with('sponsor')
            ->get()
            ->toArray();

        return Arr::pluck($activeSponsorships, 'sponsor.email');
    }
}
