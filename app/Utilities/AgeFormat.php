<?php

namespace App\Utilities;

use DateInterval;

/**
 * Class AgeFormat
 * @package App\Helpers
 */
class AgeFormat
{
    /**
     * Take a DateInterval age object and return a string that lists the number of years/months/days, depending
     * on what the value of years, months and days is.
     *
     * @param DateInterval $age
     * @return string
     */
    public static function formatToAgeString(DateInterval $age)
    {
        $format = self::getFormat($age->y, $age->m, $age->d);

        return $age->format($format);
    }

    /**
     * Get the format string that will be passed to DateInterval's format() function.
     *
     * @param int $years
     * @param int $months
     * @param int $days
     * @return string
     */
    protected static function getFormat(int $years, int $months, int $days)
    {
        $yearsString = trans_choice('date.years', $years);
        $monthsString = trans_choice('date.months', $months);
        $daysString = trans_choice('date.days', $days);

        if ($years > 0 && $months > 0) {
            return "%y {$yearsString} in %m {$monthsString}";
        }

        if ($years > 0) {
            return "%y {$yearsString}";
        }

        if ($months > 0) {
            return "%m {$monthsString}";
        }

        if ($days > 0) {
            return "%d {$daysString}";
        }

        return '1 dan';
    }
}
