<?php

namespace Tests\Browser\Admin\Pages;

class AdminDashboardPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.dashboard'));
    }
}
