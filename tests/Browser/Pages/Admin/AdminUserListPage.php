<?php

namespace Tests\Browser\Pages\Admin;

class AdminUserListPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.users'));
    }

    /**
     * @inheritDoc
     */
    public function elements()
    {
        return [
            '@user-list-role-filter' => '#bp-filters-navbar li[filter-name="role"]',
            '@user-list-permissions-filter' => '#bp-filters-navbar li[filter-name="permissions"]',
        ];
    }
}
