<?php

namespace Tests\Browser\Client\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class Navbar extends BaseComponent
{
    public function selector(): string
    {
        return '#navbar';
    }

    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    public function assertIsShowingAuthenticatedNav(Browser $browser)
    {
        $browser
            ->assertPresent('@nav-profile-button')
            ->assertPresent('@nav-logout-button')
            ->assertMissing('@nav-register-button')
            ->assertMissing('@nav-login-button');
    }

    public function assertIsShowingUnauthenticatedNav(Browser $browser)
    {
        $browser
            ->assertPresent('@nav-register-button')
            ->assertPresent('@nav-login-button')
            ->assertMissing('@nav-profile-button')
            ->assertMissing('@nav-logout-button');
    }
}
