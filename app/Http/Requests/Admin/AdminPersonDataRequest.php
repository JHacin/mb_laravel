<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\PersonDataRequest;
use App\Models\PersonData;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class AdminPersonDataRequest extends PersonDataRequest
{
    /**
     * @inheritdoc
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
        $rule = Rule::unique(PersonData::TABLE_NAME, PersonData::ATTR__EMAIL);

        $currentEntry = $this->get('id');
        if ($currentEntry !== null) {
            return $rule->ignore($currentEntry);
        }

        return $rule;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules[PersonData::ATTR__EMAIL][] = $this->getUniqueEmailRuleForPersonDataTable();

        return $rules;
    }
}
