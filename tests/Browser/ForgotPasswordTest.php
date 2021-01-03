<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ForgotPasswordPage;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;
use Throwable;

class ForgotPasswordTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_link_works()
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
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPasswordPage);
            $this->disableHtmlFormValidation($browser);
            $browser->click('@forgot-password-form-submit');
            $this->assertAllRequiredErrorsAreShown($browser, ['@email-input-wrapper']);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email_format()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ForgotPasswordPage);
            $this->disableHtmlFormValidation($browser);
            $browser
                ->type('@email-input', 'asdf')
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('validation.email'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_existing_email()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new ForgotPasswordPage)
                ->type('@email-input', 'asda@fake.com')
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('passwords.user'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_successful_submission()
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createUser();

            $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);

            $browser
                ->visit(new ForgotPasswordPage)
                ->type('@email-input', $user->email)
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('passwords.sent'));

            $this->assertDatabaseHas('password_resets', ['email' => $user->email]);
        });
    }
}
