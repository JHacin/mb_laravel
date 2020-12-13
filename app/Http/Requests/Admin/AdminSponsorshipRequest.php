<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSponsorshipRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * @return array
     */
    public function rules(): array
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
}
