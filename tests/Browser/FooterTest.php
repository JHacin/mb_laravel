<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\FAQPage;
use Tests\Browser\Pages\HomePage;
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
        });
    }
}
