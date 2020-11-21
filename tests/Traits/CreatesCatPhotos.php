<?php

namespace Tests\Traits;

use App\Models\CatPhoto;

trait CreatesCatPhotos
{
    /**
     * @param array $attributes
     * @return CatPhoto
     */
    protected function createCatPhoto($attributes = [])
    {
        /** @var CatPhoto $catPhoto */
        $catPhoto = CatPhoto::factory()->createOne($attributes);
        return $catPhoto;
    }
}
