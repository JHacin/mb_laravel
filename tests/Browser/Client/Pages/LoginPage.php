<?php

namespace Tests\Browser\Client\Pages;

use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    public function url(): string
    {
        return config('routes.login');
    }

    public function assert(Browser $browser)
    {
        parent::assert($browser);
        $browser->assertSee(trans('backpack::base.forgot_your_password'));
    }
}
