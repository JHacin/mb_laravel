<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

class HomepageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_it_works()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new HomePage)
                ->assertSee('Mačji boter');
        });
    }
}
