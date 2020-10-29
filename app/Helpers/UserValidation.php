<?php

namespace App\Helpers;

use App\Models\PersonData;
use App\Rules\CountryCode;
use Illuminate\Validation\Rule;

/**
 * Class UserValidation
 * @package App\Helpers
 */
class UserValidation
{


    public static function getAuthFieldValidationRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * @return array
     */
    public static function getCustomFieldValidationRules()
    {
        return [
            'personData.first_name' => ['nullable', 'string', 'max:255'],
            'personData.last_name' => ['nullable', 'string', 'max:255'],
            'personData.gender' => [
                Rule::in([
                    PersonData::GENDER_UNKNOWN,
                    PersonData::GENDER_MALE,
                    PersonData::GENDER_FEMALE
                ]),
            ],
            'personData.phone' => ['nullable', 'string', 'max:255'],
            'personData.date_of_birth' => ['nullable', 'date', 'before:now'],
            'personData.address' => ['nullable', 'string', 'max:255'],
            'personData.zip_code' => ['nullable', 'string', 'max:255'],
            'personData.city' => ['nullable', 'string', 'max:255'],
            'personData.country' => ['nullable', new CountryCode],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * @return string[]
     */
    public static function getCustomFieldValidationMessages()
    {
        return [
            'personData.date_of_birth.before' => 'Datum rojstva mora biti v preteklosti.',
        ];
    }
}
