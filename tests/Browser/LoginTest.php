<?php

namespace Tests\Browser;

use App\Providers\RouteServiceProvider;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Home;
use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Tests\Utilities\TestData\TestUserAuthenticated;
use Throwable;

/**
 * Class LoginTest
 * @package Tests\Browser
 */
class LoginTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Home);
            $this->goToLoginPage($browser);
            $this->missRequiredInputs($browser);
            $this->useIncorrectCredentials($browser);
            $this->useCorrectCredentials($browser);
        });
    }

    /**
     * @param Browser $browser
     */
    protected function correctNavbarLinksAreShownForUnauthenticatedUser(Browser $browser)
    {
        $browser->within(new Navbar, function ($browser) {
            $browser->assertIsShowingUnauthenticatedNav();
        });
    }

    /**
     * @param Browser $browser
     */
    protected function correctNavbarLinksAreShownForAuthenticatedUser(Browser $browser)
    {
        $browser->within(new Navbar, function ($browser) {
            $browser->assertIsShowingAuthenticatedNav();
        });
    }

    /**
     * @param Browser $browser
     */
    protected function goToLoginPage(Browser $browser)
    {
        $browser->click('@nav-login-button');
        $browser->on(new Login);
    }

    /**
     * @param Browser $browser
     */
    protected function missRequiredInputs(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $browser->type('email', 'LoremIpsum');
        $this->clickLoginSubmitButton($browser);
        $browser->on(new Login)->assertSee(trans('validation.required'));

        $browser->type('password', 'LoremIpsum');
        $this->clickLoginSubmitButton($browser);
        $browser->on(new Login)->assertSee(trans('validation.required'));
        $browser->enableClientSideValidation();
    }

    /**
     * @param Browser $browser
     */
    protected function useIncorrectCredentials(Browser $browser)
    {
        $browser->type('email', TestUserAuthenticated::getEmail());
        $browser->type('password', 'LoremIpsum');
        $this->clickLoginSubmitButton($browser);
        $browser->assertSee(trans('auth.failed'));
    }

    /**
     * @param Browser $browser
     */
    protected function useCorrectCredentials(Browser $browser)
    {
        $browser->type('email', TestUserAuthenticated::getEmail());
        $browser->type('password', TestUserAuthenticated::getPassword());
        $this->clickLoginSubmitButton($browser);
        $browser->assertPathIs(RouteServiceProvider::HOME);
    }

    /**
     * @param Browser $browser
     */
    protected function clickLoginSubmitButton(Browser $browser)
    {
        $browser->click('@login-form-submit');
    }
}
