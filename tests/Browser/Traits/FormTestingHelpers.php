<?php

namespace Tests\Browser\Traits;

use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;

trait FormTestingHelpers
{
    protected function disableHtmlFormValidation(Browser $browser)
    {
        $browser->script('for(var f=document.forms,i=f.length;i--;)f[i].setAttribute("novalidate",i)');
    }

    protected function assertAllRequiredErrorsAreShown(Browser $browser, array $requiredInputWrapperSelectors)
    {
        foreach ($requiredInputWrapperSelectors as $selector) {
            $browser->assertSeeIn($selector, trans('validation.required'));
        }
    }

    protected function assertAdminRadioHasRequiredError(Browser $browser, string $fieldName)
    {
        $browser->assertPresent('.text-danger[dusk="' . $fieldName . '-input-wrapper"]');
    }

    protected function selectInvalidSelectOption(Browser $browser, string $name)
    {
        $browser->script(
            "document.querySelector('select[name=\"" . $name . "\"] option:first-child').value = 'FAKE_VALUE';"
        );
        $browser->script(
            "document.querySelector('select[name=\"" . $name . "\"] option:first-child').removeAttribute('disabled');"
        );
        $browser->script(
            "document.querySelector('select[name=\"" . $name . "\"]').value = 'FAKE_VALUE';"
        );
    }

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
