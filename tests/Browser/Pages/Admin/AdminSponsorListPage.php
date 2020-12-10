<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorListPage extends Page
{
    /**
     * @return string
     */
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsors'));
    }

    /**
     * @inheritDoc
     */
    public function elements(): array
    {
        return [
            '@sponsors-list-is-confirmed-filter' => '#bp-filters-navbar li[filter-name="is_confirmed"]',
        ];
    }
}
