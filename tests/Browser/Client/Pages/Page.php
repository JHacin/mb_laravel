<?php

namespace Tests\Browser\Client\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

abstract class Page extends BasePage
{
    /**
     * {@inheritdoc}
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }
}
