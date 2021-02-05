<?php

namespace App\Http\Requests\Admin;

use App\Models\Sponsorship;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'payment_type' => ['required', Rule::in(Sponsorship::PAYMENT_TYPES)],
            'cat' => [
                'required',
                'integer',
                Rule::exists('cats', 'id'),
            ],
            'personData' => [
                'required',
                'integer',
                Rule::exists('person_data', 'id'),
                Rule::unique('sponsorships', 'person_data_id')
                    ->where('is_active', true)
                    ->where('cat_id', $this->input('cat'))
                    ->ignore($this->get('id'))
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'personData.unique' => 'Muca že ima aktivnega botra s tem email naslovom.',
        ];
    }
}
