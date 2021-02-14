<?php

namespace Tests\Browser\Client;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Client\Pages\HomePage;
use Tests\Browser\Client\Pages\LoginPage;
use Tests\Browser\Client\Pages\UserProfilePage;
use Tests\DuskTestCase;
use Throwable;

class LoginTest extends DuskTestCase
{
    protected User $activeUser;
    protected string $password;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        $this->password = '12345678';
//        $this->activeUser = $this->createUser([
//            'password' => User::generateSecurePassword($this->password),
//            'is_active' => true,
//        ]);
//    }

    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage);
            $this->disableHtmlFormValidation($browser);
            $browser->click('@login-form-submit');
            $this->assertAllRequiredErrorsAreShown($browser, [
                '@email-input-wrapper',
                '@password-input-wrapper'
            ]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->type('@email-input', $this->activeUser->email)
                ->type('@password-input', 'LoremIpsum')
                ->click('@login-form-submit')
                ->assertSee(trans('auth.failed'));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_user_exists_and_is_active()
    {
        $this->browse(function (Browser $b) {
            $b
                ->visit(new LoginPage)
                ->type('@email-input', 'aaaabbbb@ggg.de')
                ->type('@password-input', $this->password)
                ->click('@login-form-submit')
                ->assertSee('Uporabnik s tem e-mail naslovom ne obstaja oz. še ni aktiviran.');

            $inactive = $this->createUser([
                'password' => User::generateSecurePassword($this->password),
                'is_active' => false,
            ]);
            $b
                ->type('@email-input', $inactive->email)
                ->type('@password-input', $this->password)
                ->click('@login-form-submit')
                ->assertSee('Uporabnik s tem e-mail naslovom ne obstaja oz. še ni aktiviran.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_successful_login()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new LoginPage)
                ->type('@email-input', $this->activeUser->email)
                ->type('@password-input', $this->password)
                ->click('@login-form-submit')
                ->on(new HomePage);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_redirects_back_after_unauthenticated_access()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit((new UserProfilePage())->url())
                ->on(new LoginPage)
                ->type('@email-input', $this->activeUser->email)
                ->type('@password-input', $this->password)
                ->click('@login-form-submit')
                ->on(new UserProfilePage);
        });
    }
}
