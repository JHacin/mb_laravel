<?php

namespace App\Http\Requests\Admin;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminCatRequest extends FormRequest
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
            'name.min' => 'Ime mora biti dolgo vsaj 2 znaka.',
            'date_of_birth.before' => 'Datum rojstva mora biti v preteklosti.',
            'date_of_arrival_mh.before' => 'Datum sprejema v zavetišče mora biti v preteklosti.',
            'date_of_arrival_boter.before' => 'Datum vstopa v botrstvo mora biti v preteklosti.',
        ];
    }
}
