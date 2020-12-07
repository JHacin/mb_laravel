<?php

namespace App\Http\Requests\Admin;

class AdminSponsorshipUpdateRequest extends AdminSponsorshipRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'ended_at' => ['nullable', 'date', 'before:now'],
            ]
        );
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return array_merge(
            parent::messages(),
            [
                'ended_at.before' => 'Datum konca mora biti v preteklosti.',
            ]
        );
    }
}
