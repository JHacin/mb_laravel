<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\CatListPage;
use Tests\Browser\Pages\WhyBecomeSponsorPage;
use Tests\DuskTestCase;
use Throwable;

class WhyBecomeSponsorPageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_it_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new WhyBecomeSponsorPage);
            $b->assertSee('Zakaj postati mačji boter?');
            $b->click('@go-to-cats-list-link');
            $b->on(new CatListPage);
        });
    }
}
