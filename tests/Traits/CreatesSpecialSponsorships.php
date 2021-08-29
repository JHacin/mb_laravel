<?php

namespace Tests\Traits;

use App\Models\SpecialSponsorship;

trait CreatesSpecialSponsorships
{
    protected function createSpecialSponsorship($attributes = []): SpecialSponsorship
    {
        /** @var SpecialSponsorship $sponsorship */
        $sponsorship = SpecialSponsorship::factory()->createOne($attributes);
        return $sponsorship;
    }
}
