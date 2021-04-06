<?php

namespace Tests\Traits;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Models\Sponsorship;
use App\Services\CatPhotoService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Storage;

trait CreatesCats
{
    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCat($attributes = []): Cat
    {
        /** @var Cat $cat */
        $cat = Cat::factory()->createOne($this->withBaseAttributes($attributes));
        return $cat;
    }

    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCatWithPhotos($attributes = []): Cat
    {
        /** @var Cat $cat */
        $cat = Cat::factory()->createOne($this->withBaseAttributes($attributes));

        $indicesShuffled = Arr::shuffle(CatPhotoService::INDICES);

        foreach (CatPhotoService::INDICES as $index) {
            $fileName = "fake_cat_photo_{$indicesShuffled[$index]}.jpg";

            $file = UploadedFile::fake()->image($fileName);
            Storage::disk('public')->putFileAs(CatPhotoService::PATH_ROOT, $file, $fileName);

            CatPhoto::factory()->createOne([
                'cat_id' => $cat->id,
                'filename' => $fileName,
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
            ->createOne($this->withBaseAttributes($attributes));

        return $cat;
    }

    protected function withBaseAttributes(array $customAttributes): array
    {
        return array_merge(
            ['status' => Cat::STATUS_SEEKING_SPONSORS],
            $customAttributes
        );
    }
}
