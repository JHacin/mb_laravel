<?php

namespace Tests\Browser\Client;

use Laravel\Dusk\Browser;
use Tests\Browser\Client\Pages\BecomeSponsorOfTheMonthPage;
use Tests\Browser\Client\Pages\CatListPage;
use Tests\Browser\Client\Pages\GiftSponsorshipPage;
use Tests\Browser\Client\Pages\HomePage;
use Tests\Browser\Client\Pages\NewsPage;
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
            $b->visit(new HomePage);
            $b->assertAttribute('@navbar-contact-email-link', 'href', 'mailto:' . config('links.contact_email'));
            $b->assertAttribute('@navbar-instagram-link', 'href', config('links.instagram_page'));
            $b->assertAttribute('@navbar-facebook-link', 'href', config('links.facebook_page'));
            $b->assertMissing('.nav-link--active');

            $b->visit(new CatListPage);
            $b->click('@navbar-home-link');
            $b->on(new HomePage);

            $navLinks = [
                [
                    'dusk' => 'navbar-cat-list-link',
                    'page' => new CatListPage,
                ],
                [
                    'dusk' => 'navbar-become-sponsor-of-the-month-link',
                    'page' => new BecomeSponsorOfTheMonthPage,
                ],
                [
                    'dusk' => 'navbar-gift-sponsorship-link',
                    'page' => new GiftSponsorshipPage,
                ],
                [
                    'dusk' => 'navbar-news-link',
                    'page' => new NewsPage,
                ],
            ];

            foreach ($navLinks as $navLink) {
                $b->click('@'.$navLink['dusk']);
                $b->on($navLink['page']);
                $this->assertHasClass($b, '@'.$navLink['dusk'], 'nav-link--active');
                $b->assertMissing('.nav-link--active:not([dusk="' . $navLink['dusk'] . '"])');
            }
        });
    }

    /**
     * @throws Throwable
     */
    public function test_burger_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new HomePage);

            $defaultSize = $b->driver->manage()->window()->getSize();

            // Closed
            $this->assertNotHasClass($b, '#navbar', 'is-active');
            $this->assertNotHasClass($b, '.navbar-burger', 'is-active');

            // Open
            $b->resize(600, 600);
            $b->click('.navbar-burger');
            $this->assertHasClass($b, '#navbar', 'is-active');
            $this->assertHasClass($b, '.navbar-burger', 'is-active');

            // Closed
            $b->click('.navbar-burger');
            $this->assertNotHasClass($b, '#navbar', 'is-active');
            $this->assertNotHasClass($b, '.navbar-burger', 'is-active');

            $b->resize($defaultSize->getWidth(), $defaultSize->getHeight());
        });
    }
}
