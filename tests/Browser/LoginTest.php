<?php

namespace Tests\Browser;

use App\Providers\RouteServiceProvider;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
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
            $browser->visit(config('routes.home'));
            $this->correctNavbarLinksAreShownForUnauthenticatedUser($browser);
            $this->goToLoginPage($browser);
            $this->missRequiredInputs($browser);
            $this->useIncorrectCredentials($browser);
            $this->useCorrectCredentials($browser);
            $this->correctNavbarLinksAreShownForAuthenticatedUser($browser);
        });
    }

    /**
     * @param Browser $browser
     */
    protected function correctNavbarLinksAreShownForUnauthenticatedUser(Browser $browser)
    {
        $browser->within(new Navbar, function (Browser $browser) {
            $browser
                ->assertSee('Prijava')
                ->assertSee('Registracija')
                ->assertDontSee('Profil')
                ->assertDontSee('Odjava');
        });
    }

    /**
     * @param Browser $browser
     */
    protected function correctNavbarLinksAreShownForAuthenticatedUser(Browser $browser)
    {
        $browser->within(new Navbar, function (Browser $browser) {
            $browser
                ->assertDontSee('Prijava')
                ->assertDontSee('Registracija')
                ->assertSee('Profil')
                ->assertSee('Odjava');
        });
    }

    /**
     * @param Browser $browser
     */
    protected function goToLoginPage(Browser $browser)
    {
        $browser->click('[data-testid="nav-login-button"]');
        $browser->assertPathIs(config('routes.login'));
    }

    /**
     * @param Browser $browser
     */
    protected function missRequiredInputs(Browser $browser)
    {
        $browser->type('email', 'LoremIpsum');
        $this->clickLoginSubmitButton($browser);
        $browser->assertPathIs(config('routes.login'));

        $browser->type('password', 'LoremIpsum');
        $this->clickLoginSubmitButton($browser);
        $browser->assertPathIs(config('routes.login'));
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
        $browser->click('[data-testid="login-form-submit"]');
    }
}
