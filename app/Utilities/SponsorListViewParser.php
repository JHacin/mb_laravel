<?php

namespace App\Utilities;

use App\Models\PersonData;
use App\Models\SpecialSponsorship;
use App\Models\Sponsorship;
use Illuminate\Support\Collection;

class SponsorListViewParser
{
    /**
     * @param Collection|Sponsorship[]|SpecialSponsorship[] $sponsorships
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
     * @param Collection|Sponsorship[]|SpecialSponsorship[] $sponsorships
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
     * @param Sponsorship|SpecialSponsorship $sponsorship
     */
    protected static function isConsideredAnonymous($sponsorship): bool
    {
        return $sponsorship->is_anonymous || self::isMissingAllDisplayableProperties($sponsorship->personData);
    }

    protected static function isMissingAllDisplayableProperties(PersonData $personData): bool
    {
        return !$personData->first_name && !$personData->city;
    }
}
