<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\PersonDataRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class AdminPersonDataRequest extends PersonDataRequest
{
    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return backpack_auth()->check();
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
    public function rules()
    {
        $rules = parent::rules();

        $rules['email'][] = $this->getUniqueEmailRuleForPersonDataTable();

        return $rules;
    }
}
