<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest;

class AdminUserUpdateRequest extends UserUpdateCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), User::getSharedValidationRules());
    }

    /**
     * @inheritDoc
     */
    public function messages()
    {
        return array_merge(parent::rules(), User::getSharedValidationMessages());
    }
}
