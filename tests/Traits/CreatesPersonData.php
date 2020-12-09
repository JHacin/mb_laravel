<?php

namespace Tests\Traits;

use App\Models\PersonData;
use App\Models\Sponsorship;

trait CreatesPersonData
{
    /**
     * @param array $attributes
     * @return PersonData
     */
    protected function createPersonData($attributes = []): PersonData
    {
        /** @var PersonData $personData */
        $personData = PersonData::factory()->createOne($attributes);
        return $personData;
    }

    protected function createPersonDataWithSponsorships($attributes = []): PersonData
    {
        /** @var PersonData $personData */
        $personData = PersonData::factory()
            ->has(
                Sponsorship::factory()
                    ->count(7)
                    ->sequence(
                        ['is_active' => true],
                        ['is_active' => false]
                    )
            )->createOne($attributes);

        return $personData;
    }
}
