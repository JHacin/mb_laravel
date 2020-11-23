<?php

namespace Tests\Traits;

use App\Models\CatLocation;

trait CreatesCatLocations
{
    /**
     * @param array $attributes
     * @return CatLocation
     */
    protected function createCatLocation($attributes = [])
    {
        /** @var CatLocation $catLocation */
        $catLocation = CatLocation::factory()->createOne($attributes);
        return $catLocation;
    }
}
