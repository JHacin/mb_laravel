<?php

namespace App\Http\Requests;

use App\Models\PersonData;
use Illuminate\Foundation\Http\FormRequest;

class PersonDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return PersonData::getSharedValidationRules();
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return PersonData::getSharedValidationMessages();
    }
}
