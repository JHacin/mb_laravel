<?php

namespace Tests\Browser\Admin\Pages;

class AdminSponsorAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsors_add'));
    }
}
