<?php

namespace Tests\Browser\Admin\Pages;

class AdminSponsorshipMessageAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorship_messages_add'));
    }
}
