<?php

namespace Tests\Browser\Traits;

use Laravel\Dusk\Browser;

/**
 * Trait FormTestingHelpers
 * @package Tests\Browser\Traits
 */
trait FormTestingHelpers
{
    /**
     * @param Browser $browser
     */
    protected function disableHtmlFormValidation(Browser $browser)
    {
        $browser->script('for(var f=document.forms,i=f.length;i--;)f[i].setAttribute("novalidate",i)');
    }

    /**
     * @param Browser $browser
     */
    protected function enableHtmlFormValidation(Browser $browser)
    {
        $browser->script('for(var f=document.forms,i=f.length;i--;)f[i].removeAttribute("novalidate")');
    }

    /**
     * @param Browser $browser
     * @param array $requiredInputWrapperSelectors
     */
    protected function assertAllRequiredErrorsAreShown(Browser $browser, array $requiredInputWrapperSelectors)
    {
        foreach ($requiredInputWrapperSelectors as $selector) {
            $this->assertErrorIsShownWithin($browser, $selector, trans('validation.required'));
        }
    }

    /**
     * @param Browser $browser
     * @param string $selector
     * @param string $message
     */
    protected function assertErrorIsShownWithin(Browser $browser, string $selector, string $message)
    {
        $browser->with($selector, function (Browser $wrapper) use ($message) {
            $wrapper->assertSee($message);
        });
    }
}
