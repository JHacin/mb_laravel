<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorshipAddPage extends Page
{
    /**
     * @return string
     */
    public function url()
    {
        return $this->prefixUrl(config('routes.admin.sponsorships_add'));
    }
}
