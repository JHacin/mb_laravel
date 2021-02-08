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
            $catPhotosRoot = CatPhotoService::PATH_ROOT;

            File::copy(
                database_path("seeders/assets/fake_cat_photo_$index.jpg"),
                storage_path("app/public/{$catPhotosRoot}fake_cat_photo_$index.jpg")
            );
        }
    }
}
