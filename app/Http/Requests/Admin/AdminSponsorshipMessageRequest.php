<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminSponsorshipMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'messageType' => ['required', 'integer', Rule::exists('sponsorship_message_types', 'id')],
            'sponsor' => ['required', 'integer', Rule::exists('person_data', 'id')],
            'cat' => ['required', 'integer', Rule::exists('cats', 'id')],
            'should_send_email' => ['required', 'boolean'],
        ];
    }
}
