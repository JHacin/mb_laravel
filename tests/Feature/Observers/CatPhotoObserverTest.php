<?php

namespace Tests\Feature\Observers;

use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatPhotoObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws Exception
     */
    public function testDeletesFileFromDiskOnDelete()
    {
        Storage::fake('public');

        /** @var CatPhoto $catPhoto */
        $catPhoto = CatPhoto::factory()->createOne();
        $fileName = $catPhoto->filename;
        $file = UploadedFile::fake()->image($fileName);
        $storage = Storage::disk('public');
        $storage->putFileAs(CatPhotoService::PATH_ROOT, $file, $fileName);
        $path = CatPhotoService::getFullPath($fileName);
        $storage->assertExists($path);

        $catPhoto->delete();
        $storage->assertMissing($path);
    }
}
