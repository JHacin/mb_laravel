<?php

namespace Tests\Feature\Observers;

use App\Models\Cat;
use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
    public function testDeletesPhotosAndFilesOnDelete()
    {
        Storage::fake('public');
        $storage = Storage::disk('public');

        /** @var Cat $cat */
        $cat = Cat::factory()
            ->has(CatPhoto::factory()->count(count(CatPhotoService::INDICES)), 'photos')
            ->createOne();

        $photos = $cat->photos;

        foreach ($photos as $photo) {
            $fileName = $photo->filename;
            $file = UploadedFile::fake()->image($fileName);
            $storage->putFileAs(CatPhotoService::PATH_ROOT, $file, $fileName);
            $path = CatPhotoService::getFullPath($fileName);
            $storage->assertExists($path);
        }

        $cat->delete();

        foreach ($photos as $photo) {
            $this->assertDatabaseMissing('cat_photos', ['id' => $photo->id]);
            $fileName = $photo->filename;
            $path = CatPhotoService::getFullPath($fileName);
            $storage->assertMissing($path);
        }
    }
}
