<?php

namespace Tests\Browser\Client;

use Laravel\Dusk\Browser;
use Tests\Browser\Client\Pages\GiftSponsorshipPage;
use Tests\DuskTestCase;
use Throwable;

class GiftSponsorshipPageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_it_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new GiftSponsorshipPage);
            $b->assertSee('Botrstvo je odlično dobrodelno darilo');
        });
    }
}
