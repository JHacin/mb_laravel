<?php

namespace Tests\Feature\Observers;

use App\Services\CatPhotoService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CatPhotoObserverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @throws Exception
     */
    public function test_deletes_file_from_disk_on_delete()
    {
        $catPhoto = $this->createCatPhoto();
        $fileName = $catPhoto->filename;
        $file = UploadedFile::fake()->image($fileName);

        $storage = $this->createFakeStorage();
        $storage->putFileAs(CatPhotoService::PATH_ROOT, $file, $fileName);
        $path = CatPhotoService::getFullPath($fileName);
        $storage->assertExists($path);

        $catPhoto->delete();
        $storage->assertMissing($path);
    }
}
