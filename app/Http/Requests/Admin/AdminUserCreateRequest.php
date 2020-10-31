<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
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
            User::getSharedValidationRules(),
            ['should_send_welcome_email' => ['boolean']]
        );
    }

    /**
     * @inheritdoc
     */
    public function messages()
    {
        return array_merge(parent::rules(), User::getSharedValidationMessages());
    }
}
