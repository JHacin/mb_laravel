<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageAddPage;

class AdminSponsorshipMessageAddTest extends AdminTestCase
{
    /**
     * @param Browser $b
     * @throws TimeoutException
     */
    protected function goToPage(Browser $b)
    {
        $b->loginAs(static::$defaultAdmin);
        $b->visit(new AdminSponsorshipListPage);
        $b->click('@crud-create-button');
        $b->on(new AdminSponsorshipMessageAddPage);

        $this->waitForRequestsToFinish($b);
    }
}
