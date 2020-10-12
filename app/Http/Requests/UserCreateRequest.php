<?php

namespace App\Http\Requests;

use App\Models\User;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest;

class UserCreateRequest extends UserStoreCrudRequest
{
    /**
     * @inheritdoc
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
