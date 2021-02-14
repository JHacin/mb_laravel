<?php

namespace Tests\Browser\Admin\Pages;

class AdminUserAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.users_add'));
    }
}
