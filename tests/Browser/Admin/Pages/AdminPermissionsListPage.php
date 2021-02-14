<?php

namespace Tests\Browser\Admin\Pages;

class AdminPermissionsListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.permissions'));
    }
}
