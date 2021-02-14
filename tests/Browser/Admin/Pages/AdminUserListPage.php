<?php

namespace Tests\Browser\Admin\Pages;

class AdminUserListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.users'));
    }

    public function elements(): array
    {
        return [
            '@user-list-role-filter' => '#bp-filters-navbar li[filter-name="role"]',
            '@user-list-permissions-filter' => '#bp-filters-navbar li[filter-name="permissions"]',
        ];
    }
}
