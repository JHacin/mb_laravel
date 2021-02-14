<?php

namespace Tests\Browser\Admin;

use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminCatLocationEditPage;
use Throwable;

class AdminCatLocationEditTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_location_details()
    {
        $this->browse(function (Browser $browser) {
            $location = $this->createCatLocation();

            $browser
                ->loginAs(self::$defaultAdmin)
                ->visit(new AdminCatLocationEditPage($location))
                ->assertValue('input[name="name"]', $location->name)
                ->assertValue('input[name="address"]', $location->address)
                ->assertValue('input[name="zip_code"]', $location->zip_code)
                ->assertValue('input[name="city"]', $location->city)
                ->assertSelected('country', $location->country);
        });
    }
}
