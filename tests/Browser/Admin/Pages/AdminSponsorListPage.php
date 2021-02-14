<?php

namespace Tests\Browser\Admin\Pages;

class AdminSponsorListPage extends Page
{
    /**
     * @return string
     */
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsors'));
    }
}
