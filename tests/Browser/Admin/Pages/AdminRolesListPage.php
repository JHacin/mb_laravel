<?php

namespace Tests\Browser\Admin\Pages;

class AdminRolesListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.roles'));
    }
}
