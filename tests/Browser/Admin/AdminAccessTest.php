<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminDashboardPage;
use Tests\Browser\Pages\Admin\AdminLoginPage;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

class AdminAccessTest extends DuskTestCase
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
            /** @var User $user */
            $user = User::factory()->createOne();

            $browser
                ->loginAs($user)
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
            /** @var User $user */
            $user = User::factory()->createOne();
            $user->assignRole(User::ROLE_EDITOR);

            $browser
                ->loginAs($user)
                ->visit(new AdminDashboardPage)
                ->assertSee('Dobrodošli.');
        });
    }
}
