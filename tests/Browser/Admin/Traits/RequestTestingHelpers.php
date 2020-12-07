<?php

namespace Tests\Browser\Admin\Traits;

use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;

/**
 * Trait RequestTestingHelpers
 * @package Tests\Browser\Traits
 */
trait RequestTestingHelpers
{
    /**
     * @param Browser $browser
     * @throws TimeOutException
     */
    protected function waitForRequestsToFinish(Browser $browser)
    {
        $browser->waitUntil('!$.active');
    }
}
