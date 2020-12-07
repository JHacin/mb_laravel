<?php

namespace Tests\Unit;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Exception;
use Storage;
use Tests\TestCase;

class CatTest extends TestCase
{
    /**
     * @var Cat
     */
    protected Cat $cat;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->cat = $this->createCatWithPhotos();
    }

    /**
     * @return void
     */
    public function test_returns_photo_by_index()
    {
        $photo = $this->cat->getPhotoByIndex(1);
        $this->assertEquals(1, $photo->index);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_returns_first_photo_url()
    {
        $this->cat->getPhotoByIndex(0)->delete();
        $photo1 = $this->cat->getPhotoByIndex(1);
        $this->assertEquals(Storage::url(CatPhotoService::getFullPath($photo1->filename)), $this->cat->first_photo_url);
    }

    /**
     * @return void
     */
    public function test_returns_placeholder_image_if_photo_doesnt_exist()
    {
        $firstPhotoUrl = $this->createCat()->first_photo_url;
        $this->assertEquals($firstPhotoUrl, CatPhotoService::getPlaceholderImage());
    }

    /**
     * @return void
     */
    public function test_filters_out_inactive_cats_by_default()
    {
        $this->cat->update(['is_active' => false]);
        $this->assertFalse(Cat::all()->contains($this->cat->id));
        $this->assertTrue(Cat::withoutGlobalScopes()->get()->contains($this->cat->id));

        $this->cat->update(['is_active' => true]);
        $this->assertTrue(Cat::all()->contains($this->cat->id));
    }

    /**
     * @return void
     */
    public function test_returns_gender_label()
    {
        $this->cat->update(['gender' => Cat::GENDER_MALE]);
        $this->assertEquals('samec', $this->cat->gender_label);
    }

    /**
     * @return void
     */
    public function test_returns_name_and_id_attribute_correctly()
    {
        $this->cat->update(['name' => 'Mare']);
        $id = $this->cat->id;
        $this->assertEquals("Mare ($id)", $this->cat->name_and_id);
    }
}
