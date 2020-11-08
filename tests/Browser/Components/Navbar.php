<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

/**
 * Class Navbar
 * @package Tests\Browser\Components
 */
class Navbar extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return '#navbar';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [];
    }

    /**
     * @param Browser $browser
     */
    public function assertIsShowingAuthenticatedNav(Browser $browser)
    {
        $browser
            ->assertPresent('@nav-profile-button')
            ->assertPresent('@nav-logout-button')
            ->assertMissing('@nav-register-button')
            ->assertMissing('@nav-login-button');
    }

    /**
     * @param Browser $browser
     */
    public function assertIsShowingUnauthenticatedNav(Browser $browser)
    {
        $browser
            ->assertPresent('@nav-register-button')
            ->assertPresent('@nav-login-button')
            ->assertMissing('@nav-profile-button')
            ->assertMissing('@nav-logout-button');
    }
}
