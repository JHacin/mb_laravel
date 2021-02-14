<?php

namespace Tests\Browser\Client\Pages;

class BecomeSponsorOfTheMonthPage extends Page
{

    public function url(): string
    {
        return config('routes.become_sponsor_of_the_month');
    }
}
