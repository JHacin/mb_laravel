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
            'gender' => ['required', Rule::in(Cat::GENDERS)],
            'status' => ['required', Rule::in(Cat::STATUSES)],
            'date_of_birth' => ['nullable', 'date', 'before:now'],
            'date_of_arrival_mh' => ['nullable', 'date', 'before:now', 'after_or_equal:date_of_birth'],
            'date_of_arrival_boter' => ['nullable', 'date', 'before:now', 'after_or_equal:date_of_birth'],
            'story' => ['nullable', 'string'],
            'is_group' => ['boolean'],
        ];

        foreach (CatPhotoService::INDICES as $index) {
            $rules['photo_' . $index] = ['nullable', 'string'];
        }

        return $rules;
    }
}
