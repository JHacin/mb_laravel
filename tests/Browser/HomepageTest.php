<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class HomepageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function testHomepageWorks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(config('routes.home'))->assertSee('Mačji boter');
        });
    }
}
