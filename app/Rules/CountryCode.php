<?php

namespace App\Rules;

use App\Helpers\CountryList;
use Illuminate\Contracts\Validation\Rule;

class CountryCode implements Rule
{
    /**
     * Determine if the value is a country code.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return array_key_exists($value, CountryList::COUNTRY_NAMES);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Vrednost mora biti država.';
    }
}
