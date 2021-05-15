<?php

namespace Tests\Browser\Client\Pages;

class SpecialSponsorshipsPage extends Page
{

    public function url(): string
    {
        return config('routes.special_sponsorships');
    }
}
