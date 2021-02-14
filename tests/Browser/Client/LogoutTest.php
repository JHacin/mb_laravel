<?php

namespace Tests\Browser\Client;

use Laravel\Dusk\Browser;
use Tests\Browser\Client\Components\Navbar;
use Tests\Browser\Client\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

class LogoutTest extends DuskTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

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
