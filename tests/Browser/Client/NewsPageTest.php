<?php

namespace Tests\Browser\Client;

use Laravel\Dusk\Browser;
use Tests\Browser\Client\Pages\NewsPage;
use Tests\DuskTestCase;
use Throwable;

class NewsPageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_it_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new NewsPage);
            $b->assertSee('Novice');
        });
    }
}
