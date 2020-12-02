<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSponsorshipRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'is_anonymous' => ['boolean'],
            'monthly_amount' => [
                'required',
                'numeric',
                'min:' . config('money.donation_minimum'),
                'max:' . config('money.decimal_max'),
            ],
            'cat' => ['required', 'integer', 'exists:cats,id'],
            'personData' => ['required', 'integer', 'exists:person_data,id'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'cat.exists' => 'Muca s to šifro ne obstaja v bazi podatkov.',
            'personData.exists' => 'Uporabnik s to šifro ne obstaja v bazi podatkov.',
            'monthly_amount.min' => 'Minimalni mesečni znesek je 5€.'
        ];
    }
}
