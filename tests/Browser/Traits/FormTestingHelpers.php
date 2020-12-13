<?php

namespace Tests\Browser\Traits;

use Facebook\WebDriver\Exception\TimeOutException;
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

    /**
     * @param Browser $browser
     * @param string $name
     */
    protected function selectInvalidSelectOption(Browser $browser, string $name)
    {
        $browser->script(
            "document.querySelector('select[name=\"" . $name . "\"] option:first-child').value = 'FAKE_VALUE'"
        );
        $browser->script(
            "document.querySelector('select[name=\"" . $name . "\"]').value = 'FAKE_VALUE'"
        );
    }

    /**
     * @param Browser $browser
     * @param string $name
     * @param string $value
     */
    protected function setHiddenInputValue(Browser $browser, string $name, string $value)
    {
        $browser->script(
            "document.querySelector('input[name=\"" . $name . "\"]').value = '" . $value . "'"
        );
    }

    /**
     * @param Browser $browser
     * @param string $wrapperSelector
     * @throws TimeOutException
     */
    protected function selectFlatpickrDateInThePast(Browser $browser, string $wrapperSelector)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser->click('input[type="text"]');
        });
        $browser->whenAvailable('.flatpickr-calendar.open', function (Browser $browser) {
            $browser->click('.flatpickr-prev-month');
            $browser->click('.flatpickr-prev-month');
            $browser->click('.flatpickr-day:first-child');
        });
    }
}
