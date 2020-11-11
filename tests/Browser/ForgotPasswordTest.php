<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ForgotPasswordPage;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;
use Tests\Utilities\FormTestingUtils;
use Tests\Utilities\TestData\TestUserSuperAdmin;
use Throwable;

class ForgotPasswordTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function testLink()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->click('@login-form-forgot-password')
                ->on(new ForgotPasswordPage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPasswordPage);
            $this->shouldValidateRequiredField($browser);
            $this->shouldValidateEmailFormat($browser);
            $this->shouldValidateEmailExists($browser);
            $this->shouldShowSuccessMessageIfEmailExists($browser);
        });
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidateRequiredField(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $this->clickSubmitButton($browser);
        FormTestingUtils::assertAllRequiredErrorsAreShown($browser, ['@forgot-password-form-email-input-wrapper']);
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidateEmailFormat(Browser $browser)
    {
        $browser->disableClientSideValidation();
        $browser->type('@forgot-password-form-email-input', 'asdf');
        $this->clickSubmitButton($browser);
        $browser->assertSee(trans('validation.email'));
    }

    /**
     * @param Browser $browser
     */
    protected function shouldValidateEmailExists(Browser $browser)
    {
        $browser->type('@forgot-password-form-email-input', 'asda@fake.com');
        $this->clickSubmitButton($browser);
        $browser->assertSee(trans('passwords.user'));
    }
    /**
     * @param Browser $browser
     */
    protected function shouldShowSuccessMessageIfEmailExists(Browser $browser)
    {
        $browser->type('@forgot-password-form-email-input', TestUserSuperAdmin::getEmail());
        $this->clickSubmitButton($browser);
        $browser->assertSee(trans('passwords.sent'));
    }

    /**
     * @param Browser $browser
     */
    protected function clickSubmitButton(Browser $browser)
    {
        $browser->click('@forgot-password-form-submit');
    }
}
