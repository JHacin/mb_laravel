<?php

namespace Tests\Browser\Traits;

use Carbon\Carbon;
use Laravel\Dusk\Browser;

trait CrudTableTestingHelpers
{
    /**
     * @param Browser $browser
     */
    protected function resizeToMediumScreen(Browser $browser)
    {
        $browser->resize(1600, 900);
    }

    /**
     * @param int $index
     * @return string
     */
    protected function getTableRowSelectorForIndex(int $index)
    {
        return "#crudTable > tbody > tr:nth-child($index)";
    }

    /**
     * @param Browser $browser
     * @param array $valueMap
     */
    protected function assertDetailsModalShowsValuesInOrder(Browser $browser, array $valueMap)
    {
        foreach ($valueMap as $index => $expectedValue)
        {
            $this->assertDetailsModalColumnShowsValue($browser, $index, $expectedValue);
        }
    }

    /**
     * @param Browser $browser
     * @param int $index
     * @param mixed $expected
     */
    protected function assertDetailsModalColumnShowsValue(Browser $browser, int $index, $expected)
    {
        $browser->with(
            $this->getDetailsColumnValueSelectorByIndex($index),
            function(Browser $browser) use ($expected) {
                if (!$expected) {
                    return;
                }

                $browser->assertSee($expected);
            }
        );
    }

    /**
     * @param int $index
     * @return string
     */
    protected function getDetailsColumnValueSelectorByIndex(int $index)
    {
        return ".modal-body > table > tbody > tr[data-dt-column='$index'] > td:nth-child(2) > span";
    }

    /**
     * @param Carbon|null $date
     * @return string|void
     */
    protected function formatToDateColumnString(?Carbon $date)
    {
        if (!$date) {
            return '';
        }

        return $date->isoFormat(config('backpack.base.default_date_format'));
    }

    /**
     * @param Carbon|null $date
     * @return string|void
     */
    protected function formatToDatetimeColumnString(?Carbon $date)
    {
        if (!$date) {
            return '';
        }

        return $date->isoFormat(config('backpack.base.default_datetime_format'));
    }
}
