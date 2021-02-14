<?php

namespace Tests\Browser\Admin;

use App\Models\User;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminRolesListPage;
use Throwable;

class AdminRolesListTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_role_details()
    {
        $this->browse(function (Browser $browser) {
            $editorsCount = User::role(User::ROLE_EDITOR)->count();
            $adminsCount = User::role(User::ROLE_ADMIN)->count();
            $superAdminsCount = User::role(User::ROLE_SUPER_ADMIN)->count();

            $this->goToPage($browser);

            $browser->with(
                '#crudTable_wrapper tbody',
                function (Browser $browser) use ($editorsCount, $adminsCount, $superAdminsCount) {
                    $browser->with(
                        'tr:nth-child(1) > td:nth-child(2)',
                        function (Browser $browser) use ($editorsCount) {
                            $browser->assertSee("$editorsCount uporabnikov");
                        }
                    );
                    $browser->with(
                        'tr:nth-child(2) > td:nth-child(2)',
                        function (Browser $browser) use ($adminsCount) {
                            $browser->assertSee("$adminsCount uporabnikov");
                        }
                    );
                    $browser->with(
                        'tr:nth-child(3) > td:nth-child(2)',
                        function (Browser $browser) use ($superAdminsCount) {
                            $browser->assertSee("$superAdminsCount uporabnikov");
                        }
                    );
                }
            );
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminRolesListPage);

        $this->waitForRequestsToFinish($browser);
    }
}
