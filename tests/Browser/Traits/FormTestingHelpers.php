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
            $browser->with($selector, function (Browser $wrapper) {
                $wrapper->assertSee(trans('validation.required'));
            });
        }
    }
}
