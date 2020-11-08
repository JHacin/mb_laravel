<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\LoginPage;
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
    public function testNavbar()
    {
        $this->browse(function (Browser $browser) {
            $this->shouldShowCorrectButtonsForUnauthenticated($browser);
            $this->shouldEnableAccessToLoginPage($browser);
            $this->shouldShowCorrectButtonsForAuthenticated($browser);
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldShowCorrectButtonsForUnauthenticated(Browser $browser)
    {
        $browser
            ->visit(new HomePage)
            ->within(new Navbar, function ($browser) {
                $browser->assertIsShowingUnauthenticatedNav();
            });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldEnableAccessToLoginPage(Browser $browser)
    {
        $browser
            ->click('@nav-login-button')
            ->on(new LoginPage);
    }

    /**
     * @param Browser $browser
     */
    protected function shouldShowCorrectButtonsForAuthenticated(Browser $browser)
    {
        $browser
            ->loginAs(User::firstWhere('email', TestUserAuthenticated::getEmail()))
            ->visit(new HomePage)
            ->within(new Navbar, function ($browser) {
                $browser->assertIsShowingAuthenticatedNav();
            });
    }
}
