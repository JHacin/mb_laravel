<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatListPage;
use Tests\Browser\Pages\Admin\AdminDashboardPage;
use Tests\Browser\Pages\Admin\AdminLoginPage;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Tests\Utilities\FormTestingUtils;
use Throwable;

/**
 * Class AdminLoginTest
 * @package Tests\Browser\Admin
 */
class AdminLoginTest extends DuskTestCase
{
    /**
     * @var User
     */
    protected $adminUser;

    /**
     * @var string
     */
    protected $adminPassword;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->adminPassword = '12345678';
        $this->adminUser = $this
            ->createUser([
                'password' => User::generateSecurePassword($this->adminPassword),
            ])
            ->assignRole(User::ROLE_ADMIN);
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new AdminLoginPage);
            $this->disableHtmlFormValidation($browser);
            $browser->click('@admin-login-submit');
            FormTestingUtils::assertAllRequiredErrorsAreShown(
                $browser,
                ['@admin-login-email-input-wrapper', '@admin-login-password-input-wrapper']
            );
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_credentials()
    {
        $this->browse(function (Browser $browser) {
            $user = $this->createUser([
                'password' => User::generateSecurePassword('12345678'),
            ]);
            $browser
                ->visit(new AdminLoginPage)
                ->type('@admin-login-email-input', $user->email)
                ->type('@admin-login-password-input', '1234567812345678')
                ->click('@admin-login-submit')
                ->assertSee(trans('auth.failed'));
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_redirects_unprivileged_user_to_public_site_after_login()
    {
        $this->browse(function (Browser $browser) {
            $password = 'asdasdasd';
            $user = $this->createUser([
                'password' => User::generateSecurePassword($password),
            ]);
            $browser
                ->visit(new AdminLoginPage)
                ->type('@admin-login-email-input', $user->email)
                ->type('@admin-login-password-input', $password)
                ->click('@admin-login-submit')
                ->on(new HomePage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_redirects_admin_user_to_dashboard_after_login()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new AdminLoginPage)
                ->type('@admin-login-email-input', $this->adminUser->email)
                ->type('@admin-login-password-input', $this->adminPassword)
                ->click('@admin-login-submit')
                ->on(new AdminDashboardPage);
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
                ->visit((new AdminCatListPage())->url())
                ->on(new AdminLoginPage)
                ->type('@admin-login-email-input', $this->adminUser->email)
                ->type('@admin-login-password-input', $this->adminPassword)
                ->click('@admin-login-submit')
                ->on(new AdminCatListPage);
        });
    }
}