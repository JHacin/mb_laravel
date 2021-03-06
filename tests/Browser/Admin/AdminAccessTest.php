<?php

namespace Tests\Browser\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminDashboardPage;
use Tests\Browser\Admin\Pages\AdminLoginPage;
use Tests\Browser\Client\Pages\HomePage;
use Throwable;

class AdminAccessTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_redirects_unauthenticated_users_to_login()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit((new AdminDashboardPage())->url())
                ->on(new AdminLoginPage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_disallows_access_to_unprivileged_users()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createUser())
                ->visit((new AdminDashboardPage())->url())
                ->on(new HomePage);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_allows_admins_through()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(static::$defaultAdmin)
                ->visit(new AdminDashboardPage);
        });
    }
}
