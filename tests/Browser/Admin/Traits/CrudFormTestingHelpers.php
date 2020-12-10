<?php

namespace Tests\Browser\Admin\Traits;

use Laravel\Dusk\Browser;

trait CrudFormTestingHelpers
{
    /**
     * @param Browser $browser
     */
    protected function clickSubmitButton(Browser $browser)
    {
        $browser->click('@crud-form-submit-button');
        $this->waitForRequestsToFinish($browser);
    }

    /**
     * @param Browser $browser
     * @param string $wrapperSelector
     */
    protected function selectDatepickerDateInThePast(Browser $browser, string $wrapperSelector)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser->click('input[type="text"]');
        });

        $browser->with('.datepicker', function (Browser $browser) {
            $browser
                ->click('.datepicker-days thead th.prev')
                ->click('.datepicker-days thead th.prev')
                ->click('.datepicker-days tbody > tr > td');
        });
    }

    /**
     * @param Browser $browser
     * @param string $wrapperSelector
     */
    protected function selectDatepickerDateInTheFuture(Browser $browser, string $wrapperSelector)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser->click('input[type="text"]');
        });

        $browser->with('.datepicker', function (Browser $browser) {
            $browser
                ->click('.datepicker-days thead th.next')
                ->click('.datepicker-days thead th.next')
                ->click('.datepicker-days tbody > tr > td');
        });
    }
}
