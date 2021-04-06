<?php

namespace Tests\Unit\Models;

use App\Models\Cat;
use App\Services\CatPhotoService;
use Exception;
use Storage;
use Tests\TestCase;

class CatTest extends TestCase
{
    public function test_returns_photo_by_index()
    {
        $photo = $this->createCatWithPhotos()->getPhotoByIndex(1);
        $this->assertEquals(1, $photo->index);
    }

    /**
     * @throws Exception
     */
    public function test_returns_first_photo_url()
    {
        $cat = $this->createCatWithPhotos();
        $cat->getPhotoByIndex(0)->delete();
        $photo1 = $cat->getPhotoByIndex(1);
        $this->assertEquals(Storage::url(CatPhotoService::getFullPath($photo1->filename)), $cat->first_photo_url);
    }

    public function test_returns_placeholder_image_if_photo_doesnt_exist()
    {
        $firstPhotoUrl = $this->createCat()->first_photo_url;
        $this->assertEquals($firstPhotoUrl, CatPhotoService::getPlaceholderImage());
    }

    public function test_filters_out_cats_with_hidden_from_public_statuses_by_default()
    {
        $hiddenFromPublicStatuses = [
            Cat::STATUS_NOT_SEEKING_SPONSORS,
            Cat::STATUS_ADOPTED,
            Cat::STATUS_RIP
        ];

        foreach (Cat::STATUSES as $status) {
            $cat = $this->createCat(['status' => $status]);

            if (in_array($status, $hiddenFromPublicStatuses)) {
                $this->assertFalse(Cat::all()->contains($cat->id));
                $this->assertTrue(Cat::withoutGlobalScopes()->get()->contains($cat->id));
            } else {
                $this->assertTrue(Cat::all()->contains($cat->id));
            }
        }
    }

    public function test_returns_gender_label()
    {
        $cat = $this->createCat(['gender' => Cat::GENDER_MALE]);
        $this->assertEquals(Cat::GENDER_LABELS[Cat::GENDER_MALE], $cat->gender_label);
    }

    public function test_returns_name_and_id_attribute_correctly()
    {
        $cat = $this->createCat(['name' => 'Mare']);
        $this->assertEquals("Mare ($cat->id)", $cat->name_and_id);
    }
}
