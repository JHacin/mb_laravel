<?php

namespace Tests\Traits;

use App\Models\Cat;

trait CreatesCats
{
    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCat($attributes = [])
    {
        /** @var Cat $cat */
        $cat = Cat::factory()->createOne($attributes);
        return $cat;
    }
}
