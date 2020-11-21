<?php

namespace Tests\Browser;

use App\Providers\RouteServiceProvider;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\RegistrationPage;
use Tests\DuskTestCase;
use Tests\Utilities\FormTestingUtils;
use Tests\Utilities\TestData\TestUserEditor;
use Throwable;

/**
 * Class RegistrationTest
 * @package Tests\Browser
 */
class RegistrationTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage)->disableClientSideValidation();
            $browser->click('@register-form-submit');
            FormTestingUtils::assertAllRequiredErrorsAreShown($browser, [
                '@register-form-name-input-wrapper',
                '@register-form-email-input-wrapper',
                '@register-form-password-input-wrapper',
            ]);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_unique_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage)->disableClientSideValidation();
            $browser
                ->type('@register-form-email-input', TestUserEditor::getEmail())
                ->click('@register-form-submit')
                ->with('@register-form-email-input-wrapper', function (Browser $wrapper) {
                    $wrapper->assertSee(trans('validation.custom.email.unique'));
                });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_password_strength()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage)->disableClientSideValidation();
            $browser
                ->type('@register-form-password-input', 'x')
                ->click('@register-form-submit')
                ->with('@register-form-password-input-wrapper', function (Browser $wrapper) {
                    $wrapper->assertSee('Geslo mora biti dolgo vsaj 8 znakov.');
                });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_password_confirmation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage)->disableClientSideValidation();
            $browser
                ->type('@register-form-password-input', 'LoremIpsum')
                ->type('@register-form-password-confirm-input', 'LoremIpsumDolorAmet')
                ->click('@register-form-submit')
                ->with('@register-form-password-input-wrapper', function (Browser $wrapper) {
                    $wrapper->assertSee(trans('validation.custom.password.confirmed'));
                });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_successful_submission()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new RegistrationPage)
                ->type('@register-form-name-input', 'myusername')
                ->type('@register-form-email-input', 'john.doe@example.com')
                ->type('@register-form-password-input', 'asdf1234')
                ->type('@register-form-password-confirm-input', 'asdf1234')
                ->click('@register-form-submit')
                ->assertPathIs(RouteServiceProvider::HOME)
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingAuthenticatedNav();
                });
        });
    }
}
