<?php

namespace Tests\Browser\Pages;

class GiftSponsorshipPage extends Page
{

    public function url(): string
    {
        return config('routes.gift_sponsorship');
    }
}
