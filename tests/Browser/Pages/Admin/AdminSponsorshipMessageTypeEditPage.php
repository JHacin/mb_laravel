<?php

namespace Tests\Browser\Pages\Admin;

use App\Models\SponsorshipMessageType;

class AdminSponsorshipMessageTypeEditPage extends Page
{
    protected SponsorshipMessageType $messageType;

    public function __construct(SponsorshipMessageType $messageType)
    {
        $this->messageType = $messageType;
    }

    public function url(): string
    {
        return str_replace(
            '{id}',
            $this->messageType->id,
            $this->prefixUrl(config('routes.admin.sponsorship_message_types_edit')),
        );
    }
}
