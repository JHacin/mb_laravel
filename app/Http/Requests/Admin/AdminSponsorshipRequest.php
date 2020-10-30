<?php

namespace App\Http\Requests\Admin;

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
            'cat' => ['required', 'integer', 'exists:cats,id'],
            'personData' => ['required', 'integer', 'exists:person_data,id'],
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
            'cat_id.exists' => 'Muca s to šifro ne obstaja v bazi podatkov.',
            'user_id.exists' => 'Uporabnik s to šifro ne obstaja v bazi podatkov.',
        ];
    }
}
