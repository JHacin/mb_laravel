<?php

namespace Tests\Traits;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Models\Sponsorship;
use App\Services\CatPhotoService;
use Illuminate\Support\Arr;

trait CreatesCats
{
    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCat($attributes = []): Cat
    {
        /** @var Cat $cat */
        $cat = Cat::factory()->createOne($attributes);
        return $cat;
    }

    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCatWithPhotos($attributes = []): Cat
    {
        /** @var Cat $cat */
        $cat = Cat::factory()->createOne($attributes);

        $indicesShuffled = Arr::shuffle(CatPhotoService::INDICES);

        foreach (CatPhotoService::INDICES as $index) {
            CatPhoto::factory()->createOne([
                'cat_id' => $cat->id,
                'filename' => "fake_cat_photo_{$indicesShuffled[$index]}.jpg",
                'alt' => $cat->name,
                'index' => $index,
            ]);
        }

        return $cat;
    }

    /**
     * @param array $attributes
     * @param int $sponsorshipCount
     * @return Cat
     */
    protected function createCatWithSponsorships($attributes = [], int $sponsorshipCount = 12): Cat
    {
        /** @var Cat $cat */
        $cat = Cat::factory()
            ->has(Sponsorship::factory()->count($sponsorshipCount))
            ->createOne($attributes);

        return $cat;
    }
}
