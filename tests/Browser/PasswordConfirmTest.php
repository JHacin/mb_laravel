<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Pages\PasswordConfirmPage;
use Tests\DuskTestCase;
use Tests\Utilities\TestData\TestUserAuthenticated;
use Throwable;

class PasswordConfirmTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function testRedirectForUnauthenticated()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit((new PasswordConfirmPage)->url())
                ->on(new LoginPage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testRequiredFieldValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(User::firstWhere('email', TestUserAuthenticated::getEmail()))
                ->visit(new PasswordConfirmPage)
                ->disableClientSideValidation();

            $browser
                ->click('@password-confirm-form-submit')
                ->assertSee(trans('validation.required'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function testIncorrectPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(User::firstWhere('email', TestUserAuthenticated::getEmail()))
                ->visit(new PasswordConfirmPage)
                ->type('@password-confirm-form-input', 'LoremIpsum')
                ->click('@password-confirm-form-submit')
                ->assertSee(trans('validation.password'));
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
                ->loginAs(User::firstWhere('email', TestUserAuthenticated::getEmail()))
                ->visit(new PasswordConfirmPage)
                ->type('@password-confirm-form-input', TestUserAuthenticated::getPassword())
                ->click('@password-confirm-form-submit')
                ->assertDontSee(trans('validation.password'));
        });
    }
}
