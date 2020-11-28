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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $personDataFields = Arr::except(
            PersonData::getSharedValidationRules(),
            ['email', 'phone', 'date_of_birth']
        );
        $personDataRules = [];
        foreach ($personDataFields as $fieldName => $ruleDef) {
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
