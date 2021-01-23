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
     * @var PersonData|null
     */
    protected ?PersonData $existingPersonData = null;

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
        $this->checkIfExistingPersonData();

        return [
            'email' => [
                'required',
                'string',
                'email',
                $this->getUniqueEmailRuleForUsersTable(),
                $this->getUniqueEmailRuleForPersonDataTable(),
            ],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'gender' => [Rule::in(PersonData::GENDERS)],
            'date_of_birth' => ['nullable', 'date', 'before:now'],
            'address' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', new CountryCode],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return void
     */
    protected function checkIfExistingPersonData()
    {
        $currentEntryId = $this->get('id');
        if ($currentEntryId) {
            $this->existingPersonData = PersonData::find($currentEntryId);
        }
    }

    /**
     * @return Unique
     */
    protected function getUniqueEmailRuleForUsersTable(): Unique
    {
        $rule = Rule::unique('users', 'email');

        if ($this->existingPersonData && $this->existingPersonData->user_id) {
            return $rule->ignore($this->existingPersonData->user_id);
        }

        return $rule;
    }

    /**
     * @return Unique
     */
    protected function getUniqueEmailRuleForPersonDataTable(): Unique
    {
        $rule = Rule::unique('person_data', 'email');

        if ($this->existingPersonData) {
            return $rule->ignore($this->existingPersonData);
        }

        return $rule;
    }
}
