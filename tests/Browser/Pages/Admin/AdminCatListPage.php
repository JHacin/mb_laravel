<?php

namespace Tests\Browser\Pages\Admin;

class AdminCatListPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.cats'));
    }

    /**
     * @inheritDoc
     */
    public function elements()
    {
        return [
            '@cats-list-location-filter' => '#bp-filters-navbar li[filter-name="location_id"]',
            '@cats-list-gender-filter' => '#bp-filters-navbar li[filter-name="gender"]',
            '@cats-list-is-active-filter' => '#bp-filters-navbar li[filter-name="is_active"]',
        ];
    }
}
