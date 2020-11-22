<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Pages\UserProfilePage;
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
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->password = '12345678';
        $this->user = $this->createUser([
            'password' => User::generateSecurePassword($this->password),
        ]);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LoginPage);
            $this->disableHtmlFormValidation($browser);
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
            $browser
                ->visit(new LoginPage)
                ->type('@login-form-email-input', $this->user->email)
                ->type('@login-form-password-input', $this->password)
                ->click('@login-form-submit')
                ->on(new HomePage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_redirects_back_after_unauthenticated_access()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit((new UserProfilePage())->url())
                ->on(new LoginPage)
                ->type('@login-form-email-input', $this->user->email)
                ->type('@login-form-password-input', $this->password)
                ->click('@login-form-submit')
                ->on(new UserProfilePage);
        });
    }
}
