<?php

namespace App\Http\Requests\Admin;

use App\Models\SpecialSponsorship;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSpecialSponsorshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(SpecialSponsorship::TYPES)],
            'personData' => [
                'required',
                'integer',
                Rule::exists('person_data', 'id'),
            ],
        ];
    }
}
