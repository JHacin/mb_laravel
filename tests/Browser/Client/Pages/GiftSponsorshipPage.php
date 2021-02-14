<?php

namespace Tests\Browser\Client\Pages;

class GiftSponsorshipPage extends Page
{

    public function url(): string
    {
        return config('routes.gift_sponsorship');
    }
}
