<?php

namespace Tests\Browser\Pages\Admin;

class AdminDashboardPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.dashboard'));
    }
}
