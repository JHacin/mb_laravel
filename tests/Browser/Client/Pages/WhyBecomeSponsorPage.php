<?php

namespace Tests\Browser\Client\Pages;

class WhyBecomeSponsorPage extends Page
{

    public function url(): string
    {
        return config('routes.why_become_sponsor');
    }
}
