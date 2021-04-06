<?php

namespace Tests\Browser\Admin\Traits;

use Laravel\Dusk\Browser;

trait CrudFilterTestingHelpers
{
    /**
     * @param Browser $browser
     * @param string $wrapperSelector
     */
    protected function assertSeeBooleanTypeFilter(Browser $browser, string $wrapperSelector)
    {
        $browser->with($wrapperSelector, function (Browser $browser) {
            $browser
                ->click('a.dropdown-toggle')
                ->assertSee('Da')
                ->assertSee('Ne');
        });
    }

    protected function assertFilterDropdownHasValues(Browser $browser, string $filterName, array $values)
    {
        $browser->with("#bp-filters-navbar li[filter-name=\"$filterName\"]", function (Browser $browser) use ($values) {
            $browser->click('a.dropdown-toggle');

            foreach ($values as $value) {
                $browser->assertPresent(".dropdown-item[dropdownkey=\"$value\"]");
            }
        });
    }

    protected function clickBooleanTypeFilterValue(Browser $browser, string $wrapperSelector, bool $value)
    {
        $browser->with($wrapperSelector, function (Browser $browser) use ($value) {
            $browser
                ->click('a.dropdown-toggle')
                ->click('.dropdown-item[dropdownkey="' . (int)$value . '"]');
        });
        $this->waitForRequestsToFinish($browser);
    }
}
