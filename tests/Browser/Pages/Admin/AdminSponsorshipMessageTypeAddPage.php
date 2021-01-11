<?php

namespace Tests\Browser\Pages\Admin;

class AdminSponsorshipMessageTypeAddPage extends Page
{
    public function url(): string
    {
        return $this->prefixUrl(config('routes.admin.sponsorship_message_types_add'));
    }
}
