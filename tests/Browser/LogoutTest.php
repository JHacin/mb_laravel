<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

class LogoutTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_handles_logout()
    {
        $this->browse(function (Browser $b) {
            $b->loginAs($this->createUser());
            $b->visit(new HomePage);
            $b->click('@navbar-profile-section');
            $b->with('@navbar-profile-section', function (Browser $b) {
                $b->click('@nav-logout-button');
            });
            $b->within(new Navbar, function ($browser) {
                $browser->assertIsShowingUnauthenticatedNav();
            });
        });
    }
}
