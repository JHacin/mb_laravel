<?php

namespace Tests\Browser\Admin\Pages;

use App\Models\User;

class AdminUserEditPage extends Page
{
    protected ?User $user = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function url(): string
    {
        return str_replace('{id}', $this->user->id, $this->prefixUrl(config('routes.admin.users_edit')));
    }
}
