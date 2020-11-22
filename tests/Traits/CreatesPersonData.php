<?php

namespace Tests\Traits;

use App\Models\PersonData;

trait CreatesPersonData
{
    /**
     * @param array $attributes
     * @return PersonData
     */
    protected function createPersonData($attributes = [])
    {
        /** @var PersonData $personData */
        $personData = PersonData::factory()->createOne($attributes);
        return $personData;
    }
}