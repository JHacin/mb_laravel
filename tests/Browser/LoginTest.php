<?php

namespace Tests\Browser;

use App\Providers\RouteServiceProvider;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;
use Tests\Utilities\FormTestingUtils;
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
            $browser->visit(new LoginPage);
            $this->shouldValidateRequiredFields($browser);
            $this->shouldValidateCredentials($browser);
            $this->shouldLogUserInOnSuccessfulAuthentication($browser);
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidateRequiredFields(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $this->clickLoginSubmitButton($browser);
        FormTestingUtils::assertAllRequiredErrorsAreShown($browser, [
            '@login-form-email-input-wrapper',
            '@login-form-password-input-wrapper'
        ]);
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidateCredentials(Browser $browser)
    {
        $browser->type('@login-form-email-input', TestUserAuthenticated::getEmail());
        $browser->type('@login-form-password-input', 'LoremIpsum');
        $this->clickLoginSubmitButton($browser);
        $browser->assertSee(trans('auth.failed'));
    }

    /**
     * @param Browser $browser
     */
    protected function shouldLogUserInOnSuccessfulAuthentication(Browser $browser)
    {
        $browser->type('@login-form-email-input', TestUserAuthenticated::getEmail());
        $browser->type('@login-form-password-input', TestUserAuthenticated::getPassword());
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
