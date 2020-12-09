<?php

namespace App\Http\Requests\Admin;

use App\Models\PersonData;
use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class AdminSponsorRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email'),
                $this->getUniqueEmailRuleForPersonDataTable(),
            ],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'gender' => [Rule::in(PersonData::GENDERS)],
            'phone' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before:now'],
            'address' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', new CountryCode],
        ];
    }

    /**
     * @return Unique
     */
    protected function getUniqueEmailRuleForPersonDataTable()
    {
        $rule = Rule::unique('person_data', 'email');

        $currentEntry = $this->get('id');
        if ($currentEntry !== null) {
            return $rule->ignore($currentEntry);
        }

        return $rule;
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return PersonData::getSharedValidationMessages();
    }
}
