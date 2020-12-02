<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Admin\AdminTestCase;
use Tests\Browser\Pages\Admin\AdminPermissionsListPage;
use Throwable;

class AdminPermissionsListTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_the_right_page()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser
                ->assertSee('Dovoljenja')
                ->assertSee('Na voljo ni podatkov.');
        });
    }

    /**
     * @param Browser $browser
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminPermissionsListPage);
    }
}
