<?php

namespace Tests\Browser\Admin\Pages;

class AdminSponsorshipMessageTypeListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorship_message_types'));
    }
}
