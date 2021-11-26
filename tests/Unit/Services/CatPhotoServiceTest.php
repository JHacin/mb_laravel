<?php

namespace Tests\Unit\Services;

use App\Services\CatPhotoService;
use Tests\TestCase;

class CatPhotoServiceTest extends TestCase
{
    const SAMPLE_BASE64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    public function test_validates_base64_image()
    {
        $this->assertFalse(CatPhotoService::isBase64ImageString('data:imagx'));
        $this->assertTrue(CatPhotoService::isBase64ImageString(self::SAMPLE_BASE64));
    }

    public function test_creates_image()
    {
        $storage = $this->createFakeStorage();
        $cat = $this->createCat();
        $service = new CatPhotoService();

        $photo = $service->create($cat, self::SAMPLE_BASE64, 3);

        $expectedFilename = md5(self::SAMPLE_BASE64 . time()) . '.jpg';

        $this->assertEquals($expectedFilename, $photo->filename);
        $this->assertEquals(3, $photo->index);
        $this->assertEquals($cat->id, $photo->cat_id);
        $this->assertTrue($cat->photos->contains($photo->id));
        $this->assertTrue($storage->has(CatPhotoService::getFullPath($expectedFilename)));
    }

    public function test_returns_full_image_path()
    {
        $filename = 'muca.jpg';
        $this->assertEquals('muce/slike/' . $filename, CatPhotoService::getFullPath($filename));
    }

    public function test_deletes_file_from_disk()
    {
        $storage = $this->createFakeStorage();
        $cat = $this->createCat();
        $service = new CatPhotoService();

        $filename = $service->create($cat, self::SAMPLE_BASE64, 2)->filename;
        $this->assertTrue($storage->has(CatPhotoService::getFullPath($filename)));
        $service->deleteFromDisk($filename);
        $this->assertFalse($storage->has(CatPhotoService::getFullPath($filename)));
    }
}
