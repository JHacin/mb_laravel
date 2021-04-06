<?php

namespace Tests\Browser\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminCatEditPage;
use Throwable;

class AdminCatEditTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_shows_cat_details()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCatWithPhotos(['story' => 'hello']);

            $b->loginAs(static::$defaultAdmin);
            $b->visit(new AdminCatEditPage($cat));

            $this->waitForRequestsToFinish($b);

            $b->assertValue('input[name="name"]', $cat->name);
            $b->assertValue('input[name="gender"]', $cat->gender);
            $b->assertValue('select[name="status"]', $cat->status);
            $b->assertValue('input[name="is_group"]', (int)$cat->is_group);
            $b->assertValue('input[name="date_of_birth"]', $cat->date_of_birth->toDateString());
            $b->assertValue('input[name="date_of_arrival_mh"]', $cat->date_of_arrival_mh->toDateString());
            $b->assertValue('input[name="date_of_arrival_boter"]', $cat->date_of_arrival_boter->toDateString());
            $b->assertAttribute('.preview-image[data-field-name="photo_0"', 'alt', 'Slika 1');
            $b->assertScript('CKEDITOR.instances.story.getData().includes(\'<p>hello</p>\')');
            $b->assertAttribute('select[name="location_id"', 'data-current-value', $cat->location->id);
        });
    }
}
