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
        return array_merge(
            Sponsorship::getSharedValidationRules(),
            [
                'cat' => ['required', 'integer', 'exists:cats,id'],
                'personData' => ['required', 'integer', 'exists:person_data,id'],
            ]
        );
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return array_merge(
            Sponsorship::getSharedValidationMessages(),
            [
                'cat.exists' => 'Muca s to šifro ne obstaja v bazi podatkov.',
                'personData.exists' => 'Uporabnik s to šifro ne obstaja v bazi podatkov.',
            ]
        );
    }
}
