<?php

namespace App\Http\Requests;

use App\Models\User;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest;

class UserUpdateRequest extends UserUpdateCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), User::getCustomFieldValidationRules());
    }

    /**
     * @inheritdoc
     */
    public function messages()
    {
        return array_merge(parent::rules(), User::getCustomFieldValidationMessages());
    }
}
