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
    public function testRequiredFieldValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPasswordPage)->disableClientSideValidation();
            $browser->click('@forgot-password-form-submit');
            FormTestingUtils::assertAllRequiredErrorsAreShown($browser, ['@forgot-password-form-email-input-wrapper']);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testEmailFormatValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPasswordPage)->disableClientSideValidation();
            $browser
                ->type('@forgot-password-form-email-input', 'asdf')
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('validation.email'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testEmailExistsValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new ForgotPasswordPage)
                ->type('@forgot-password-form-email-input', 'asda@fake.com')
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('passwords.user'));
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
                ->visit(new ForgotPasswordPage)
                ->type('@forgot-password-form-email-input', TestUserSuperAdmin::getEmail())
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('passwords.sent'));
        });
    }
}
