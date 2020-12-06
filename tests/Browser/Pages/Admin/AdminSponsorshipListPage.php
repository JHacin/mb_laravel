<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorshipListPage extends Page
{
    /**
     * @return string
     */
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorships'));
    }

    /**
     * @inheritDoc
     */
    public function elements(): array
    {
        return [
            '@sponsorship-list-location-filter' => '#bp-filters-navbar li[filter-name="cat"]',
            '@sponsorship-list-person-data-filter' => '#bp-filters-navbar li[filter-name="personData"]',
            '@sponsorship-list-is-active-filter' => '#bp-filters-navbar li[filter-name="is_active"]',
        ];
    }
}
