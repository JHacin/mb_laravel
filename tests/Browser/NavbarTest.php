<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BecomeSponsorOfTheMonthPage;
use Tests\Browser\Pages\CatListPage;
use Tests\Browser\Pages\GiftSponsorshipPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\NewsPage;
use Tests\Browser\Pages\WhyBecomeSponsorPage;
use Tests\DuskTestCase;
use Throwable;

/**
 * Class NavbarTest
 * @package Tests\Browser
 */
class NavbarTest extends DuskTestCase
{
   /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_logged_out_buttons()
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');

//        $this->browse(function (Browser $browser) {
//            $browser
//                ->visit(new HomePage)
//                ->within(new Navbar, function ($browser) {
//                    $browser->assertIsShowingUnauthenticatedNav();
//                });
//        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_logged_in_buttons()
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');

//        $this->browse(function (Browser $browser) {
//            $browser
//                ->loginAs($this->createUser())
//                ->visit(new HomePage)
//                ->within(new Navbar, function ($browser) {
//                    $browser->assertIsShowingAuthenticatedNav();
//                });
//        });
    }

    /**
     * @throws Throwable
     */
    public function test_desktop_links_work()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new CatListPage);
            $b->click('@navbar-home-link');
            $b->on(new HomePage);

            $b->click('@navbar-become-regular-sponsor-category');
            $b->with('@navbar-become-regular-sponsor-category', function (Browser $b) {
                $b->click('@navbar-cat-list-link');
            });
            $b->on(new CatListPage);

            $b->click('@navbar-become-regular-sponsor-category');
            $b->with('@navbar-become-regular-sponsor-category', function (Browser $b) {
                $b->click('@navbar-why-become-sponsor-link');
            });
            $b->on(new WhyBecomeSponsorPage);

            $b->click('@navbar-become-sponsor-of-the-month-link');
            $b->on(new BecomeSponsorOfTheMonthPage);

            $b->click('@navbar-gift-sponsorship-link');
            $b->on(new GiftSponsorshipPage);

            $b->click('@navbar-news-link');
            $b->on(new NewsPage);
        });
    }
}
