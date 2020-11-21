<?php

namespace Tests\Browser;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\DuskTestCase;
use Tests\Utilities\FormTestingUtils;
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
    public function test_validates_required_fields()
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
    public function test_validates_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->type('@login-form-email-input', 'asd@example.com')
                ->type('@login-form-password-input', 'LoremIpsum')
                ->click('@login-form-submit')
                ->assertSee(trans('auth.failed'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_successful_login()
    {
        $this->browse(function (Browser $browser) {
            /** @var User $user */
            $user = User::factory()->createOne([
                'password' => User::generateSecurePassword('hello123456')
            ]);

            $browser
                ->visit(new LoginPage)
                ->type('@login-form-email-input', $user->email)
                ->type('@login-form-password-input', 'hello123456')
                ->click('@login-form-submit')
                ->assertPathIs(RouteServiceProvider::HOME);
        });
    }
}
