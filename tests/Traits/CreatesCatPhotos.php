<?php

namespace Tests\Traits;

use App\Models\CatPhoto;

trait CreatesCatPhotos
{
    protected function createCatPhoto($attributes = []): CatPhoto
    {
        /** @var CatPhoto $catPhoto */
        $catPhoto = CatPhoto::factory()->createOne($attributes);
        return $catPhoto;
    }
}
