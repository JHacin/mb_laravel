<?php

namespace App\Http\Requests\Admin;

use App\Helpers\UserValidation;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest;

class AdminUserCreateRequest extends UserStoreCrudRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            UserValidation::getCustomFieldValidationRules(),
            ['should_send_welcome_email' => ['boolean']]
        );
    }

    /**
     * @inheritdoc
     */
    public function messages()
    {
        return array_merge(parent::rules(), UserValidation::getCustomFieldValidationMessages());
    }
}
