<?php

namespace Tests\Browser\Admin\Pages;

class AdminSponsorshipMessageListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorship_messages'));
    }
}
