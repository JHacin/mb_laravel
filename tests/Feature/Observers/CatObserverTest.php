<?php

namespace Tests\Feature\Observers;

use App\Services\CatPhotoService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws Exception
     */
    public function test_deletes_photos_and_files_on_delete()
    {
        $storage = $this->createFakeStorage();
        $cat = $this->createCatWithPhotos();
        $photos = $cat->photos;

        foreach ($photos as $photo) {
            $path = CatPhotoService::getFullPath($photo->filename);
            $storage->assertExists($path);
        }

        $cat->delete();
        foreach ($photos as $photo) {
            $this->assertDatabaseMissing('cat_photos', ['id' => $photo->id]);
            $path = CatPhotoService::getFullPath($photo->filename);
            $storage->assertMissing($path);
        }
    }
}
