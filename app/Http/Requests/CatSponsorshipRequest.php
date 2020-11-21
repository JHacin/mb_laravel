<?php

namespace App\Http\Requests;

use App\Models\PersonData;
use App\Models\Sponsorship;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CatSponsorshipRequest extends FormRequest
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
        $personDataRules = [];

        foreach (Arr::except(PersonData::getSharedValidationRules(), ['email']) as $fieldName => $ruleDef) {
            $personDataRules['personData.' . $fieldName] = $ruleDef;
        }

        return array_merge(
            $personDataRules,
            Sponsorship::getSharedValidationRules(),
            [
                'personData.email' => [
                    'required',
                    'string',
                    'email',
                    Rule::unique('users', 'email')->ignore(Auth::id())
                ],
                'is_agreed_to_terms' => 'accepted'
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        $personDataMessages = [];

        foreach (PersonData::getSharedValidationMessages() as $validatorName => $message) {
            $personDataMessages['personData.' . $validatorName] = $message;
        }

        return array_merge(
            $personDataMessages,
            Sponsorship::getSharedValidationMessages(),
            [
                'personData.email.unique' =>
                    'Ta email naslov že uporablja registriran uporabnik.' .
                    ' Če je email naslov vaš in ga želite uporabiti, se prosimo najprej prijavite v račun.'
            ]
        );
    }
}
