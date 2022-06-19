<?php

namespace Database\Seeders;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CatSeeder extends Seeder
{
    public function run()
    {
        $cats = Cat::factory()->count(100)->create();
        $cats->push(Cat::factory()->createOne(['is_group' => true]));
        $cats->push(Cat::factory()->createOne(['is_group' => true]));
        $cats->push(Cat::factory()->createOne(['is_group' => true]));

        foreach ($cats as $cat) {
            $indicesShuffled = Arr::shuffle(CatPhotoService::INDICES);

            foreach (CatPhotoService::INDICES as $index) {
                CatPhoto::factory()->createOne([
                    'cat_id' => $cat->id,
                    'filename' => "fake_cat_photo_{$indicesShuffled[$index]}.jpg",
                    'alt' => $cat->name,
                    'index' => $index,
                ]);
            }
        }

        foreach (CatPhotoService::INDICES as $index) {
            $pathRoot = CatPhotoService::PATH_ROOT;
            $photosDirectory = storage_path("app/public/{$pathRoot}");

            // On fresh install, the root dir does not exist.
            if (!File::isDirectory($photosDirectory)) {
                File::makeDirectory($photosDirectory, 0777, true, true);
            }

            File::copy(
                database_path("seeders/assets/fake_cat_photo_$index.jpg"),
                "{$photosDirectory}/fake_cat_photo_$index.jpg"
            );
        }
    }
}
