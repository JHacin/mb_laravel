<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

class HomepageTest extends DuskTestCase
{
    /**
     * @throws Throwable
     */
    public function test_it_renders_expected_content()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new HomePage);
            $this->assertCount(3, $b->elements('.hero-cat'));
            $b->assertPresent('.home-header');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_toggles_between_fixed_and_static_navbar_on_scroll()
    {
        $this->browse(function (Browser $b) {
            $defaultSize = $b->driver->manage()->window()->getSize();
            $b->visit(new HomePage);
            // Static nav
            $b->assertScript("document.querySelector('html').classList.contains('is-homepage') === true");
            $b->with('.navbar', function (Browser $b) {
               $b->assertMissing('.nav-logo');
               $b->assertMissing('.navbar-end');
            });

            // Scrolled past header (fixed nav)
            $b->scrollIntoView('footer');
            $b->resize(1600, 600);
            $b->assertScript("document.querySelector('html').classList.contains('is-homepage') === false");
            $b->with('.navbar', function (Browser $b) {
                $b->assertPresent('.nav-logo');
                $b->assertPresent('.navbar-end');
            });

            // Scrolled back to top (static nav)
            $b->scrollIntoView('.home-header');
            $b->resize(1600, 600);
            $b->assertScript("document.querySelector('html').classList.contains('is-homepage') === true");
            $b->with('.navbar', function (Browser $b) {
                $b->assertMissing('.nav-logo');
                $b->assertMissing('.navbar-end');
            });

            $b->resize($defaultSize->getWidth(), $defaultSize->getHeight());
        });
    }
}
