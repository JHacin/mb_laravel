<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Home;
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
            $browser
                ->visit(new Home)
                ->assertSee('Mačji boter');
        });
    }
}
