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
    public function testRegistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage);
            $this->shouldValidateRequiredFields($browser);
            $this->shouldDisallowUsingExistingEmail($browser);
            $this->shouldValidatePasswordStrength($browser);
            $this->shouldValidatePasswordConfirmation($browser);
            $this->shouldHandleSuccessfulSubmission($browser);
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidateRequiredFields(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $this->clickSubmitButton($browser);
        FormTestingUtils::assertAllRequiredErrorsAreShown($browser, [
            '@register-form-name-input-wrapper',
            '@register-form-email-input-wrapper',
            '@register-form-password-input-wrapper',
        ]);
    }

    /**
     * @param Browser $browser
     */
    protected function shouldDisallowUsingExistingEmail(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $browser->type('@register-form-email-input', TestUserEditor::getEmail());
        $this->clickSubmitButton($browser);
        $browser->with('@register-form-email-input-wrapper', function (Browser $wrapper) {
            $wrapper->assertSee(trans('validation.custom.email.unique'));
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidatePasswordStrength(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $browser->type('@register-form-password-input', 'x');
        $this->clickSubmitButton($browser);
        $browser->with('@register-form-password-input-wrapper', function (Browser $wrapper) {
            $wrapper->assertSee('Geslo mora biti dolgo vsaj 8 znakov.');
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidatePasswordConfirmation(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $browser->type('@register-form-password-input', 'LoremIpsum');
        $browser->type('@register-form-password-confirm-input', 'LoremIpsumDolorAmet');
        $this->clickSubmitButton($browser);
        $browser->with('@register-form-password-input-wrapper', function (Browser $wrapper) {
            $wrapper->assertSee(trans('validation.custom.password.confirmed'));
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldHandleSuccessfulSubmission(Browser $browser)
    {
        $browser->type('@register-form-name-input', 'myusername');
        $browser->type('@register-form-email-input', 'john.doe@example.com');
        $browser->type('@register-form-password-input', 'asdf1234');
        $browser->type('@register-form-password-confirm-input', 'asdf1234');
        $this->clickSubmitButton($browser);
        $browser->assertPathIs(RouteServiceProvider::HOME);
        $browser->within(new Navbar, function ($browser) {
            $browser->assertIsShowingAuthenticatedNav();
        });
    }

    /**
     * @param Browser $browser
     */
    protected function clickSubmitButton(Browser $browser)
    {
        $browser->click('@register-form-submit');
    }
}
