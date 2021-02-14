<?php

namespace Tests\Browser\Admin\Pages;

class AdminSponsorshipAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorships_add'));
    }
}
