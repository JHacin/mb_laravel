<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class ExampleTest extends DuskTestCase
{

    /**
     * A basic browser test example.
     *
     * @return void
     * @throws Throwable
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Mačji boter');
        });
    }


    /**
     * @throws Throwable
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('login'))
                ->type('email', 'test@example.com')
                ->type('password', 'asdf12345')
                ->press('Prijava')
                ->assertSee('Nepravilen email naslov in/ali geslo.');
        });
    }
}
