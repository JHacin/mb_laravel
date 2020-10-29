<?php

namespace App\Http\Requests\Admin;

use App\Helpers\UserValidation;
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
        return array_merge(parent::rules(), UserValidation::getCustomFieldValidationRules());
    }

    /**
     * @inheritdoc
     */
    public function messages()
    {
        return array_merge(parent::rules(), UserValidation::getCustomFieldValidationMessages());
    }
}
