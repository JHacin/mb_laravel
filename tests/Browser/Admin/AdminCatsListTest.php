<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatListPage;
use Tests\DuskTestCase;
use Throwable;

class AdminCatsListTest extends DuskTestCase
{
    /**
     * @var Cat
     */
    protected $cat;

    /**
     * @return void
     * @throws Throwable
     */
    public function test_cats_list()
    {
        $this->browse(function (Browser $browser) {
            $this->cat = $this->createCat();

            $browser
                ->loginAs($this->createAdminUser())
                ->visit(new AdminCatListPage);

            $this->waitForRequestsToFinish($browser);

            $browser->with('#crudTable > tbody > tr:nth-child(1)', function (Browser $browser) {
                $browser->assertSee($this->cat->id);
            });
        });
    }
}
