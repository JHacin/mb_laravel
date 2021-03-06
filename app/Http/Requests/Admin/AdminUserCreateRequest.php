<?php

namespace App\Http\Requests\Admin;

use App\Models\PersonData;
use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserCreateRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'unique:' . config('permission.table_names.users', 'users') . ',email'
            ],
            'name' => ['required'],
            'password' => ['required', 'confirmed'],
            'personData.first_name' => ['nullable', 'string', 'max:255'],
            'personData.last_name' => ['nullable', 'string', 'max:255'],
            'personData.gender' => ['required', Rule::in(PersonData::GENDERS)],
            'personData.date_of_birth' => ['nullable', 'date', 'before:now'],
            'personData.address' => ['nullable', 'string', 'max:255'],
            'personData.zip_code' => ['nullable', 'string', 'max:255'],
            'personData.city' => ['nullable', 'string', 'max:255'],
            'personData.country' => ['nullable', new CountryCode],
            'is_active' => ['boolean'],
            'should_send_welcome_email' => ['boolean']
        ];
    }
}
