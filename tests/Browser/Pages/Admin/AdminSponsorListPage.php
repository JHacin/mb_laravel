<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorListPage extends Page
{
    /**
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.sponsors'));
    }
}
