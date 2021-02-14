<?php

namespace Tests\Browser\Admin\Pages;

class AdminLoginPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.login'));
    }
}
