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
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->createUser())
                ->visit(new HomePage)
                ->click('@nav-logout-button')
                ->within(new Navbar, function ($browser) {
                    $browser->assertIsShowingUnauthenticatedNav();
                });
        });
    }
}
