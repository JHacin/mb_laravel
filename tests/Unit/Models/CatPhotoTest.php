<?php

namespace Tests\Unit\Models;


use App\Models\CatPhoto;
use App\Services\CatPhotoService;
use Storage;
use Tests\TestCase;

class CatPhotoTest extends TestCase
{
    protected ?CatPhoto $catPhoto = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->catPhoto = $this->createCatPhoto();
    }

    /**
     * @return void
     */
    public function test_returns_full_url()
    {
        $this->assertEquals(
            Storage::url(CatPhotoService::getFullPath($this->catPhoto->filename)),
            $this->catPhoto->url
        );
    }
}
