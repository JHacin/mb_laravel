<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LoginPage;
use Tests\Browser\Pages\PasswordConfirmPage;
use Tests\DuskTestCase;
use Throwable;

class PasswordConfirmTest extends DuskTestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser([
            'password' => User::generateSecurePassword('asdf123456')
        ]);
    }


    /**
     * @return void
     * @throws Throwable
     */
    public function test_redirects_not_logged_in_user()
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
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new PasswordConfirmPage);
            $this->disableHtmlFormValidation($browser);
            $browser
                ->click('@password-confirm-form-submit')
                ->assertSee(trans('validation.required'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_password()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new PasswordConfirmPage)
                ->type('@password-input', 'LoremIpsum')
                ->click('@password-confirm-form-submit')
                ->assertSee(trans('validation.password'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_successful_submission()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(new PasswordConfirmPage)
                ->type('@password-input', 'asdf123456')
                ->click('@password-confirm-form-submit')
                ->assertDontSee(trans('validation.password'));
        });
    }
}
