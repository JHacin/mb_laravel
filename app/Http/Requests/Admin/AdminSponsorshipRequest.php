<?php

namespace App\Http\Requests\Admin;

use App\Models\Sponsorship;
use Illuminate\Foundation\Http\FormRequest;

class AdminSponsorshipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Sponsorship::ATTR__CAT => ['required', 'integer', 'exists:cats,id'],
            Sponsorship::ATTR__PERSON_DATA => ['required', 'integer', 'exists:person_data,id'],
            Sponsorship::ATTR__IS_ANONYMOUS => ['boolean'],
            Sponsorship::ATTR__MONTHLY_AMOUNT => ['required', 'numeric', 'between:0,' . config('money.decimal_max')],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            Sponsorship::ATTR__CAT . '.exists' => 'Muca s to šifro ne obstaja v bazi podatkov.',
            Sponsorship::ATTR__PERSON_DATA . '.exists' => 'Uporabnik s to šifro ne obstaja v bazi podatkov.',
        ];
    }
}
