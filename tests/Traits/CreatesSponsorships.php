<?php

namespace Tests\Traits;

use App\Models\Sponsorship;

trait CreatesSponsorships
{
    protected function createSponsorship($attributes = []): Sponsorship
    {
        /** @var Sponsorship $sponsorship */
        $sponsorship = Sponsorship::factory()->createOne($attributes);
        return $sponsorship;
    }

}
