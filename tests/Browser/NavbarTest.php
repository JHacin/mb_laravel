<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Tests\Utilities\TestData\TestUserAuthenticated;
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
                ->loginAs(User::firstWhere('email', TestUserAuthenticated::getEmail()))
                ->visit(new HomePage)
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingAuthenticatedNav();
                });
        });
    }
}
