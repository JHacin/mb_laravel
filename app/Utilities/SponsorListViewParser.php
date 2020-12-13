<?php

namespace App\Utilities;

use App\Models\PersonData;
use App\Models\Sponsorship;
use Illuminate\Database\Eloquent\Collection;

class SponsorListViewParser
{
    /**
     * Prepare various useful variables used in sponsor lists on the front end.
     *
     * @param Collection|Sponsorship[] $sponsorships
     * @return array[]
     */
    public static function prepareViewData($sponsorships): array
    {
        $separated = self::separateAnonymousSponsors($sponsorships);

        return [
            'anonymous' => $separated['anonymous'],
            'anonymous_count_label' => trans_choice('sponsor.anonymous_count', count($separated['anonymous'])),
            'identified' => $separated['identified'],
        ];
    }

    /**
     * @param Collection|Sponsorship[] $sponsorships
     * @return array[]
     */
    protected static function separateAnonymousSponsors($sponsorships): array
    {
        $result = [
            'anonymous' => [],
            'identified' => [],
        ];

        foreach ($sponsorships as $sponsorship) {
            if (self::isConsideredAnonymous($sponsorship)) {
                $result['anonymous'][] = $sponsorship->personData;
            } else {
                $result['identified'][] = $sponsorship->personData;
            }
        }

        return $result;
    }

    /**
     * @param Sponsorship $sponsorship
     * @return bool
     */
    protected static function isConsideredAnonymous(Sponsorship $sponsorship): bool
    {
        return $sponsorship->is_anonymous || self::isMissingAllDisplayableProperties($sponsorship->personData);
    }

    /**
     * @param PersonData $personData
     * @return bool
     */
    protected static function isMissingAllDisplayableProperties(PersonData $personData): bool
    {
        return !$personData->first_name && !$personData->city;
    }
}
