<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorshipMessageTypeListPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorship_message_types'));
    }
}
