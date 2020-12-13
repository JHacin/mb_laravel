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
    protected function clickCheckbox(Browser $browser, string $wrapperSelector)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser->click('input[data-init-function="bpFieldInitCheckbox"]');
        });
    }

    /**
     * @param Browser $browser
     * @param string $wrapperSelector
     * @param int $monthsAgo
     */
    protected function selectDatepickerDateInThePast(Browser $browser, string $wrapperSelector, int $monthsAgo = 2)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser->click('input[type="text"]');
        });

        $browser->with('.datepicker', function (Browser $browser) use ($monthsAgo) {
            for ($i = 0; $i < $monthsAgo; $i++) {
                $browser->click('.datepicker-days thead th.prev');
            }

            $browser->click('.datepicker-days tbody > tr > td');
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
