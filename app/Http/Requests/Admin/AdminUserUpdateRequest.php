<?php

namespace App\Http\Requests\Admin;

use App\Models\PersonData;
use App\Models\User;
use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return backpack_auth()->check();
    }

    /**
     * @return array
     */
    public function rules()
    {
        $userModel = config('backpack.permissionmanager.models.user');
        $userModel = new $userModel();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->get('id') ?? \Request::instance()->segment($routeSegmentWithId);

        if (!$userModel->find($userId)) {
            abort(400, 'Could not find that entry in the database.');
        }

        return [
            'email' => [
                'required',
                'string',
                'email',
                'unique:' . config('permission.table_names.users', 'users') . ',email,' . $userId
            ],
            'name' => ['required'],
            'password' => ['confirmed'],
            'personData.first_name' => ['nullable', 'string', 'max:255'],
            'personData.last_name' => ['nullable', 'string', 'max:255'],
            'personData.gender' => [Rule::in(PersonData::GENDERS)],
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
     * @inheritDoc
     */
    public function messages()
    {
        return User::getSharedValidationMessages();
    }
}
