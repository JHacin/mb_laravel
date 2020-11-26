<?php

namespace Tests\Unit\Services;

use App\Services\CatPhotoService;
use Tests\TestCase;

class CatPhotoServiceTest extends TestCase
{
    const SAMPLE_BASE64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';

    /**
     * @return void
     */
    public function test_validates_base64_image()
    {
        $this->assertFalse(CatPhotoService::isBase64ImageString('data:imagx'));
        $this->assertTrue(CatPhotoService::isBase64ImageString(self::SAMPLE_BASE64));
    }

    /**
     * @return void
     */
    public function test_creates_image_from_base64()
    {
        $storage = $this->createFakeStorage();
        $service = new CatPhotoService();
        $filename = $service->createImageFromBase64(self::SAMPLE_BASE64);
        $this->assertIsString($filename);
        $this->assertTrue($storage->has(CatPhotoService::getFullPath($filename)));
    }

    /**
     * @return void
     */
    public function test_returns_full_image_path()
    {
        $filename = 'muca.jpg';
        $this->assertEquals('muce/slike/' . $filename, CatPhotoService::getFullPath($filename));
    }

    /**
     * @return void
     */
    public function test_creates_and_associates_cat_photo()
    {
        $service = new CatPhotoService();
        $cat = $this->createCat();
        $photo = $service->create($cat, 'test.png', 3);
        $this->assertEquals('test.png', $photo->filename);
        $this->assertEquals(3, $photo->index);
        $this->assertEquals($cat->id, $photo->cat_id);
        $this->assertTrue($cat->photos->contains($photo->id));
    }

    /**
     * @return void
     */
    public function test_deletes_file_from_disk()
    {
        $storage = $this->createFakeStorage();
        $service = new CatPhotoService();
        $filename = $service->createImageFromBase64(self::SAMPLE_BASE64);
        $this->assertTrue($storage->has(CatPhotoService::getFullPath($filename)));
        $service->deleteFromDisk($filename);
        $this->assertFalse($storage->has(CatPhotoService::getFullPath($filename)));
    }
}
