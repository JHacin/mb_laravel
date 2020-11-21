<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

/**
 * Class NavbarTest
 * @package Tests\Browser
 */
class NavbarTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_logged_out_buttons()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new HomePage)
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingUnauthenticatedNav();
                });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_logged_in_buttons()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createUser())
                ->visit(new HomePage)
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingAuthenticatedNav();
                });
        });
    }
}
