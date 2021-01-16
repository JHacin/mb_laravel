<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorshipMessageListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorship_messages'));
    }
}
