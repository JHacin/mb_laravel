<?php

namespace Tests\Browser;

use Carbon\Carbon;
use DB;
use Laravel\Dusk\Browser;
use Password;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\ResetPasswordPage;
use Tests\DuskTestCase;
use Throwable;

class ResetPasswordTest extends DuskTestCase
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
    public function test_uses_email_from_query_param()
    {
        $this->browse(function (Browser $b) {
            $email = 'test@example.com';

            $this->goToPage($b, 'token', $email);
            $b->assertQueryStringHas('email', $email);
            $b->assertInputValue('email', $email);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, 'token', '');
            $this->disableHtmlFormValidation($b);
            $this->submit($b);

            $this->assertAllRequiredErrorsAreShown($b, [
                '@email-input-wrapper',
                '@password-input-wrapper',
            ]);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_email()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, 'token', '');
            $this->disableHtmlFormValidation($b);
            $b->type('@email-input', 'aaddfgghn');
            $this->submit($b);

            $b->assertSeeIn('@email-input-wrapper', 'Vrednost mora biti veljaven email naslov.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_password()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b, 'token', '');

            $this->disableHtmlFormValidation($b);
            $b->type('@password-input', 'aa');
            $b->type('@password_confirmation-input', 'aa');
            $this->submit($b);
            $b->assertSeeIn('@password-input-wrapper', 'Geslo mora biti dolgo vsaj 8 znakov.');

            $this->disableHtmlFormValidation($b);
            $b->type('@password-input', 'aaaaaaaaaaaa');
            $b->type('@password_confirmation-input', 'aabbbbbbbbbb');
            $this->submit($b);
            $b->assertSeeIn('@password-input-wrapper', 'Gesli se ne ujemata.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_token()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUser();
            $token = Password::createToken($user);
            $this->goToPage($b, $token . 'a', $user->email);
            $b->type('@password-input', 'asdasdasd');
            $b->type('@password_confirmation-input', 'asdasdasd');
            $this->submit($b);

            $b->assertSeeIn('@email-input-wrapper', 'Žeton za ponastavitev gesla ni veljaven.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_token_expiration()
    {
        $this->browse(function (Browser $b) {
            $expirationInMinutes = 60;
            $user = $this->createUser();
            $token = Password::createToken($user);
            DB::table('password_resets')
                ->where('email', $user->email)
                ->update(['created_at' => Carbon::now()->subMinutes($expirationInMinutes + 1)]);

            $this->goToPage($b, $token, $user->email);
            $b->type('@password-input', 'asdasdasd');
            $b->type('@password_confirmation-input', 'asdasdasd');
            $this->submit($b);

            $b->assertSeeIn('@email-input-wrapper', 'Žeton za ponastavitev gesla ni veljaven.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_handles_successful_reset()
    {
        $this->browse(function (Browser $b) {
            $user = $this->createUser();
            $token = Password::createToken($user);
            $this->goToPage($b, $token, $user->email);

            $b->type('@password-input', 'asdasdasd');
            $b->type('@password_confirmation-input', 'asdasdasd');
            $this->submit($b);

            $b->on(new HomePage);
        });
    }

    protected function goToPage(Browser $b, string $token, string $email)
    {
        $b->visit((new ResetPasswordPage($token, $email))->url());
    }

    protected function submit(Browser $b)
    {
        $b->click('@reset-password-form-submit');
    }
}
