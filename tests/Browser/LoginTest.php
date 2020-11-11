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
    public function testRequiredFieldsValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage)->disableClientSideValidation();
            $browser->click('@login-form-submit');
            FormTestingUtils::assertAllRequiredErrorsAreShown($browser, [
                '@login-form-email-input-wrapper',
                '@login-form-password-input-wrapper'
            ]);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testCredentialsValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->type('@login-form-email-input', TestUserAuthenticated::getEmail())
                ->type('@login-form-password-input', 'LoremIpsum')
                ->click('@login-form-submit')
                ->assertSee(trans('auth.failed'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->type('@login-form-email-input', TestUserAuthenticated::getEmail())
                ->type('@login-form-password-input', TestUserAuthenticated::getPassword())
                ->click('@login-form-submit')
                ->assertPathIs(RouteServiceProvider::HOME);
        });
    }
}
