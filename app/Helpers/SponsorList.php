<?php

namespace App\Helpers;

use App\Models\Sponsorship;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class SponsorList
{
    /**
     * Return whether the sponsor should be included as anonymous (missing all of the fields required for display).
     * Todo: handle sponsors that explicitly marked themselves as anonymous (if that field is added to Sponsorship).
     *
     * @param User $sponsor
     * @return bool
     */
    protected static function isAnonymousSponsor(User $sponsor)
    {
        return !$sponsor->first_name && !$sponsor->city;
    }

    /**
     * Separate anonymous and identified ("non"-anonymous) sponsors for easier handling on the front end.
     *
     * @param Collection|Sponsorship[] $sponsorships
     * @return array[]
     */
    protected static function separateAnonymousSponsors($sponsorships)
    {
        $result = [
            'anonymous' => [],
            'identified' => [],
        ];

        foreach ($sponsorships as $sponsorship) {
            $sponsor = $sponsorship->user;

            if (self::isAnonymousSponsor($sponsor)) {
                $result['anonymous'][] = $sponsor;
            } else {
                $result['identified'][] = $sponsor;
            }
        }

        return $result;
    }

    /**
     * Generate the text for the number of anonymous sponsors at the end of a sponsor list.
     *
     * @param int $count
     * @return string
     */
    protected static function getAnonymousCountLabel(int $count)
    {
        switch ($count) {
            case 1:
                return '1 anonimni boter';

            case 2:
                return '2 anonimna botra';

            case 3:
            case 4:
                return $count . ' anonimni botri';

            default:
                return $count . ' anonimnih botrov';
        }
    }

    /**
     * Prepare various useful variables used in sponsor lists on the front end.
     *
     * @param Collection|Sponsorship[] $sponsorships
     * @return array[]
     */
    public static function prepareViewData($sponsorships)
    {
        $separated = self::separateAnonymousSponsors($sponsorships);

        return [
            'anonymous' => $separated['anonymous'],
            'anonymous_count_label' => self::getAnonymousCountLabel(count($separated['anonymous'])),
            'identified' => $separated['identified'],
        ];
    }
}
