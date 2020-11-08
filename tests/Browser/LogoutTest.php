<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Tests\Utilities\TestData\TestUserAuthenticated;
use Throwable;

class LogoutTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs(User::firstWhere('email', TestUserAuthenticated::getEmail()))
                ->visit(new HomePage)
                ->click('@nav-logout-button')
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingUnauthenticatedNav();
                });
        });
    }
}
