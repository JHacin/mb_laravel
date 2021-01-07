<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\FAQPage;
use Tests\Browser\Pages\HomePage;
use Tests\Browser\Pages\PrivacyPage;
use Tests\DuskTestCase;
use Throwable;

class FooterTest extends DuskTestCase
{
    /**
     * @throws Throwable
     */
    public function test_prefooter_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new HomePage);
            $b->click('@footer-faq-link');
            $b->on(new FAQPage);

            $b->visit(new HomePage);
            $b->click('@footer-mh-link');
            $b->assertUrlIs(config('links.macja_hisa'));

            $b->visit(new HomePage);
            $b->click('@footer-vet-link');
            $b->assertUrlIs(config('links.veterina_mh'));

            $b->visit(new HomePage);
            $b->click('@footer-combe-link');
            $b->assertUrlIs(config('links.super_combe'));
        });
    }

    /**
     * @throws Throwable
     */
    public function test_footer_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new HomePage);
            $b->assertSeeIn('@footer-bottom', date('Y') . ' Mačji boter');

            $b->click('@footer-privacy-link');
            $b->on(new PrivacyPage);
        });
    }
}
