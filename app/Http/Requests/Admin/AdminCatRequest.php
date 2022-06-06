<?php

namespace App\Http\Requests\Admin;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminCatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'gender' => ['required_if:is_group,0', 'nullable', Rule::in(Cat::GENDERS)],
            'status' => ['required', Rule::in(Cat::STATUSES)],
            'date_of_birth' => ['nullable', 'date', 'before:now'],
            'date_of_arrival_mh' => ['nullable', 'date', 'before:now', 'after_or_equal:date_of_birth'],
            'date_of_arrival_boter' => ['nullable', 'date', 'before:now', 'after_or_equal:date_of_birth'],
            'story_short' => ['required', 'string', 'max:'.config('validation.cat.story_short_maxlength') ],
            'story' => ['nullable', 'string'],
            'is_group' => ['boolean'],
        ];

        foreach (CatPhotoService::INDICES as $index) {
            $rules['photo_' . $index] = ['nullable', 'string'];
        }

        return $rules;
    }
}
