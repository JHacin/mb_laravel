<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\RegistrationPage;
use Tests\DuskTestCase;
use Throwable;

class RegistrationTest extends DuskTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage);
            $this->disableHtmlFormValidation($browser);
            $browser->click('@register-form-submit');
            $this->assertAllRequiredErrorsAreShown($browser, [
                '@name-input-wrapper',
                '@email-input-wrapper',
                '@password-input-wrapper',
            ]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_unique_email()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage);
            $this->disableHtmlFormValidation($browser);
            $browser
                ->type('@email-input', $this->createUser()->email)
                ->click('@register-form-submit')
                ->with('@email-input-wrapper', function (Browser $wrapper) {
                    $wrapper->assertSee(trans('validation.custom.email.unique'));
                });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_password_strength()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage);
            $this->disableHtmlFormValidation($browser);
            $browser
                ->type('@password-input', 'x')
                ->click('@register-form-submit')
                ->with('@password-input-wrapper', function (Browser $wrapper) {
                    $wrapper->assertSee('Geslo mora biti dolgo vsaj 8 znakov.');
                });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_password_confirmation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new RegistrationPage);
            $this->disableHtmlFormValidation($browser);
            $browser
                ->type('@password-input', 'LoremIpsum')
                ->type('@password_confirmation-input', 'LoremIpsumDolorAmet')
                ->click('@register-form-submit')
                ->with('@password-input-wrapper', function (Browser $wrapper) {
                    $wrapper->assertSee(trans('validation.custom.password.confirmed'));
                });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_successful_submission()
    {
        $this->browse(function (Browser $browser) {
            $user = $this->makeUser();

            $browser
                ->visit(new RegistrationPage)
                ->type('@name-input', $user->name)
                ->type('@email-input', $user->email)
                ->type('@password-input', 'asdf1234')
                ->type('@password_confirmation-input', 'asdf1234')
                ->click('@register-form-submit')
                ->on(new HomePage)
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingAuthenticatedNav();
                });

            $this->assertDatabaseHas('users', [
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => true,
            ]);
        });
    }
}
