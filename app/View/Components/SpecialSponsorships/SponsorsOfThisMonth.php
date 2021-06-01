<?php

namespace App\View\Components\SpecialSponsorships;

use App\Models\SpecialSponsorship;
use App\Utilities\SponsorListViewParser;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SponsorsOfThisMonth extends Component
{
    public function render(): View
    {
        $title = $this->generateTitle();
        $sponsorshipsPerType = $this->getSponsorshipsPerType();

        return view('components.special-sponsorships.sponsors-of-this-month', [
            'title' => $title,
            'sponsorshipsPerType' => $sponsorshipsPerType,
        ]);
    }

    private function getSponsorshipsPerType(): array
    {
        $sponsorshipsForCurrentMonth = $this->getSponsorshipsForCurrentMonth();
        $sponsorshipsPerType = $this->groupSponsorshipsPerType($sponsorshipsForCurrentMonth);

        return $sponsorshipsPerType;
    }

    private function getSponsorshipsForCurrentMonth(): Collection
    {
        $now = Carbon::now();

        $sponsorships = SpecialSponsorship
            ::whereYear('confirmed_at', '=', $now->year)
            ->whereMonth('confirmed_at', '=', $now->month)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        return $sponsorships;
    }

    private function groupSponsorshipsPerType(Collection $sponsorshipsForCurrentMonth): array
    {
        $result = $this->associateSponsorshipsWithType($sponsorshipsForCurrentMonth);
        $result = $this->removeTypesWithNoMatches($result);
        $result = $this->parseAnonymousVsIdentifiedSponsors($result);

        return $result;
    }

    private function associateSponsorshipsWithType(Collection $sponsorships): array
    {
        $types = array_values(SpecialSponsorship::TYPES);
        $result = array_fill_keys($types, []);

        foreach ($sponsorships as $sponsorship) {
            $result[$sponsorship->type][] = $sponsorship;
        }

        return $result;
    }

    private function removeTypesWithNoMatches(array $sponsorshipsPerType): array
    {
        $result = array_filter($sponsorshipsPerType, function ($value) {
            return sizeof($value) > 0;
        }, ARRAY_FILTER_USE_BOTH);

        return $result;
    }

    private function parseAnonymousVsIdentifiedSponsors(array $sponsorshipsPerType): array
    {
        $result = [];

        foreach ($sponsorshipsPerType as $type => $sponsorships) {
            $result[$type] = SponsorListViewParser::prepareViewData($sponsorships);
        }

        return $result;
    }

    private function generateTitle(): string
    {
        $now = Carbon::now();
        $month = trans_choice('date.month_genitive', $now->month);
        $year = $now->year;

        return  "Botri $month $year";
    }
}
