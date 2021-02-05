<?php

namespace Tests\Browser\Admin\Traits;

use Laravel\Dusk\Browser;

trait CrudFormTestingHelpers
{
    protected function clickSubmitButton(Browser $browser)
    {
        $browser->click('@crud-form-submit-button');
        $this->waitForRequestsToFinish($browser);
    }

    protected function clickCheckbox(Browser $browser, string $wrapperSelector)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser->click('input[data-init-function="bpFieldInitCheckbox"]');
        });
    }

    protected function selectRadioOption(Browser $browser, string $wrapperSelector, $value)
    {
        $browser->with($wrapperSelector, function (Browser $b) use ($value) {
            $b->click('input[value="' . $value . '"]');
        });
    }

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
