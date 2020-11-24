<?php

namespace Tests\Traits;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use Illuminate\Http\UploadedFile;

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

    /**
     * @param array $attributes
     * @return Cat
     */
    protected function createCatWithPhotos($attributes = [])
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
}
