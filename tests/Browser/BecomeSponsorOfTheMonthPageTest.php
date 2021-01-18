<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\BecomeSponsorOfTheMonthPage;
use Tests\DuskTestCase;
use Throwable;

class BecomeSponsorOfTheMonthPageTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_it_works()
    {
        $this->browse(function (Browser $b) {
            $b->visit(new BecomeSponsorOfTheMonthPage);
            $b->assertSee('Postani boter meseca z enkratnim prispevkom 10 €');
        });
    }
}
