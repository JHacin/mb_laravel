<?php

namespace App\Http\Requests\Admin;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminCatRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'gender' => [
                Rule::in([
                    Cat::GENDER_UNKNOWN,
                    Cat::GENDER_MALE,
                    Cat::GENDER_FEMALE
                ]),
            ],
            'date_of_birth' => ['nullable', 'date', 'before:now'],
            'date_of_arrival_mh' => ['nullable', 'date', 'before:now'],
            'date_of_arrival_boter' => ['nullable', 'date', 'before:now'],
            'story' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];

        foreach (CatPhotoService::INDICES as $index) {
            $rules['photo_' . $index] = ['nullable', 'string'];
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.min' => 'Ime mora biti dolgo vsaj 2 znaka.',
            'date_of_birth.before' => 'Datum rojstva mora biti v preteklosti.',
            'date_of_arrival_mh.before' => 'Datum sprejema v zavetišče mora biti v preteklosti.',
            'date_of_arrival_boter.before' => 'Datum vstopa v botrstvo mora biti v preteklosti.',
        ];
    }
}
