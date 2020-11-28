<?php

namespace Tests\Browser\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatEditPage;
use Throwable;

class AdminCatEditTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_cat_details()
    {
        $this->browse(function (Browser $browser) {
            $cat = $this->createCatWithPhotos(['story' => 'hello']);

            $browser
                ->loginAs(static::$defaultAdmin)
                ->visit(new AdminCatEditPage($cat))
                ->assertValue('input[name="name"]', $cat->name)
                ->assertValue('input[name="gender"]', $cat->gender)
                ->assertValue('input[name="date_of_birth"]', $cat->date_of_birth->toDateString())
                ->assertValue('input[name="date_of_arrival_mh"]', $cat->date_of_arrival_mh->toDateString())
                ->assertValue('input[name="date_of_arrival_boter"]', $cat->date_of_arrival_boter->toDateString())
                ->assertAttribute('.preview-image[data-field-name="photo_0"', 'alt', 'Slika 1')
                ->assertScript('CKEDITOR.instances.story.getData().includes(\'<p>hello</p>\')')
                ->assertAttribute('select[name="location_id"', 'data-current-value', $cat->location->id)
                ->assertValue('input[name="is_active"', $cat->is_active);
        });
    }
}
