<?php

namespace App\Http\Requests;

use App\Models\PersonData;
use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')->ignore(Auth::id())],
            'password' => ['nullable', 'string', 'min:8', 'max:255', 'confirmed'],
            'personData.first_name' => ['nullable', 'string', 'max:255'],
            'personData.last_name' => ['nullable', 'string', 'max:255'],
            'personData.gender' => [Rule::in(PersonData::GENDERS)],
            'personData.phone' => ['nullable', 'string', 'max:255'],
            'personData.date_of_birth' => ['nullable', 'date', 'before:now'],
            'personData.address' => ['nullable', 'string', 'max:255'],
            'personData.zip_code' => ['nullable', 'string', 'max:255'],
            'personData.city' => ['nullable', 'string', 'max:255'],
            'personData.country' => ['nullable', new CountryCode],
        ];
    }
}
