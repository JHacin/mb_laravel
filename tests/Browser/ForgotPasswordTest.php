<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ForgotPasswordPage;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;
use Tests\Utilities\FormTestingUtils;
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
            $browser->visit(new ForgotPasswordPage)->disableClientSideValidation();
            $browser->click('@forgot-password-form-submit');
            FormTestingUtils::assertAllRequiredErrorsAreShown($browser, ['@forgot-password-form-email-input-wrapper']);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email_format()
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
    public function test_validates_existing_email()
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
            /** @var User $user */
            $user = User::factory()->createOne();

            $browser
                ->visit(new ForgotPasswordPage)
                ->type('@forgot-password-form-email-input', $user->email)
                ->click('@forgot-password-form-submit')
                ->assertSee(trans('passwords.sent'));
        });
    }
}
