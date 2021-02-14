<?php

namespace Tests\Traits;

use App\Models\CatLocation;

trait CreatesCatLocations
{
    protected function createCatLocation($attributes = []): CatLocation
    {
        /** @var CatLocation $catLocation */
        $catLocation = CatLocation::factory()->createOne($attributes);
        return $catLocation;
    }
}
