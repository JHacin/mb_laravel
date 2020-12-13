<?php

namespace Tests\Traits;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Models\Sponsorship;
use App\Services\CatPhotoService;
use Illuminate\Http\UploadedFile;

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
        $storage = $this->createFakeStorage();

        /** @var Cat $cat */
        $cat = Cat::factory()
            ->has(CatPhoto::factory()->count(count(CatPhotoService::INDICES)), 'photos')
            ->createOne($attributes);

        foreach ($cat->photos as $photo) {
            $fileName = $photo->filename;
            $file = UploadedFile::fake()->image($fileName);
            $storage->putFileAs(CatPhotoService::PATH_ROOT, $file, $fileName);
        }

        return $cat;
    }

    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCatWithSponsorships($attributes = []): Cat
    {
        /** @var Cat $cat */
        $cat = Cat::factory()
            ->has(Sponsorship::factory()->count(12))
            ->createOne($attributes);

        return $cat;
    }
}
