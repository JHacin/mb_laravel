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
                'ended_at' => ['nullable', 'date', 'before_or_equal:now'],
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
                'ended_at.before_or_equal' => 'Datum konca ne sme biti v prihodnosti.',
            ]
        );
    }
}
