<?php

namespace Tests\Browser\Traits;

use Laravel\Dusk\Browser;

trait ElementTestingHelpers
{
    /**
     * @param Browser $browser
     * @param string $selector
     * @param string $class
     */
    protected function assertHasClass(Browser $browser, string $selector, string $class)
    {
        $this->assertStringContainsString($class, $browser->attribute($selector, 'class'));
    }
    /**
     * @param Browser $browser
     * @param string $selector
     * @param string $class
     */
    protected function assertNotHasClass(Browser $browser, string $selector, string $class)
    {
        $this->assertStringNotContainsString($class, $browser->attribute($selector, 'class'));
    }
}
