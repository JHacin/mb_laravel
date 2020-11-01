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
        $years = $age->y;
        $months = $age->m;
        $days = $age->d;

        $format = self::getFormat($years, $months, $days);

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
        $yearsString = self::formatYearsString($years);
        $monthsString = self::formatMonthsString($months);
        $daysString = self::formatDaysString($days);

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

    /**
     * Get the Slovene word that corresponds to a certain number of years.
     *
     * @param int $years
     * @return string
     */
    protected static function formatYearsString(int $years)
    {
        switch ($years) {
            case 1:
                return 'leto';

            case 2:
                return 'leti';

            case 3:
            case 4:
                return 'leta';

            default:
                return 'let';
        }
    }

    /**
     * Get the Slovene word that corresponds to a certain number of months.
     *
     * @param int $months
     * @return string
     */
    protected static function formatMonthsString(int $months)
    {
        switch ($months) {
            case 1:
                return 'mesec';

            case 2:
                return 'meseca';

            case 3:
            case 4:
                return 'meseci';

            default:
                return 'mesecev';
        }
    }

    /**
     * Get the Slovene word that corresponds to a certain number of days.
     *
     * @param int $days
     * @return string
     */
    protected static function formatDaysString(int $days)
    {
        switch ($days) {
            case 1:
                return 'dan';

            case 2:
                return 'dneva';

            case 3:
            case 4:
                return 'dnevi';

            default:
                return 'dni';
        }
    }
}
