<?php

namespace Tests\Traits;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;

trait CreatesSponsorships
{
    protected function createSponsorship($attributes = []): Sponsorship
    {
        /** @var Sponsorship $sponsorship */
        $sponsorship = Sponsorship::factory()->createOne($attributes);
        return $sponsorship;
    }

    protected function createSponsorshipWithCatAndSponsor($attributes = []): Sponsorship
    {
        /** @var Sponsorship $sponsorship */
        $sponsorship = Sponsorship::factory()->createOne($attributes);

        // using factory->for() or setting id as attribute is flaky in tests
        $sponsorship->cat()->associate(Cat::factory()->createOne());
        $sponsorship->sponsor()->associate(PersonData::factory()->createOne());

        return $sponsorship;
    }
}
