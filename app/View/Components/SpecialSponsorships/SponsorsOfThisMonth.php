<?php

namespace App\View\Components\SpecialSponsorships;

use App\Models\SpecialSponsorship;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SponsorsOfThisMonth extends Component
{
    public function render(): View
    {
        $title = $this->generateTitle();
        $sponsorsPerType = $this->getSponsorsPerSponsorshipType();

        return view('components.special-sponsorships.sponsors-of-this-month', [
            'title' => $title,
            'sponsorsPerType' => $sponsorsPerType,
        ]);
    }

    private function getSponsorsPerSponsorshipType(): array
    {
        $sponsorshipsForCurrentMonth = $this->getSponsorshipsForCurrentMonth();
        $sponsorsPerType = $this->groupSponsorsPerType($sponsorshipsForCurrentMonth);

        return $sponsorsPerType;
    }

    private function getSponsorshipsForCurrentMonth(): Collection
    {
        $now = Carbon::now();

        return SpecialSponsorship
            ::whereYear('confirmed_at', '=', $now->year)
            ->whereMonth('confirmed_at', '=', $now->month)
            ->orderBy('confirmed_at', 'desc')
            ->get();
    }

    /*
     * Returns an array with type keys & personData[] values (e.g. 1 => [PersonData, PersonData, ...])
     */
    private function groupSponsorsPerType(Collection $sponsorshipsForCurrentMonth): array
    {
        $types = array_values(SpecialSponsorship::TYPES);
        $result = array_fill_keys($types, []);

        /** @var SpecialSponsorship $sponsorship */
        foreach ($sponsorshipsForCurrentMonth as $sponsorship) {
            $result[$sponsorship->type][] = $sponsorship->personData;
        }

        $result = array_filter($result, function ($value) {
            return sizeof($value) > 0;
        }, ARRAY_FILTER_USE_BOTH);

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
