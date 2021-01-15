<?php

namespace Tests\Browser\Admin;

use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorshipMessageTypeListPage;
use Throwable;

class AdminSponsorshipMessageTypeListTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_shows_message_type_details_correctly()
    {
        $this->browse(function (Browser $b) {
            $messageType = $this->createSponsorshipMessageType();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);

            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($messageType) {
                $this->assertDetailsModalShowsValuesInOrder($b, [
                    0 => $messageType->id,
                    1 => $messageType->name,
                    2 => $messageType->template_id,
                    3 => $messageType->is_active ? 'Da' : 'Ne',
                ]);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_deletes_message_type()
    {
        $this->browse(function (Browser $b) {
            $messageType = $this->createSponsorshipMessageType();
            $this->goToPage($b);

            $b->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) use ($messageType) {
                $browser
                    ->assertSee($messageType->name)
                    ->click('a[data-button-type="delete"]');
            });
            $b->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Izbriši');
            });

            $this->waitForRequestsToFinish($b);
            $b->assertDontSee($messageType->name);
            $this->assertDatabaseMissing('sponsorship_message_types', ['id' => $messageType->id]);
        });
    }

    /**
     * @param Browser $b
     * @throws TimeoutException
     */
    protected function goToPage(Browser $b)
    {
        $b->loginAs(static::$defaultAdmin);
        $b->visit(new AdminSponsorshipMessageTypeListPage);

        $this->waitForRequestsToFinish($b);
        $this->clearActiveFilters($b);
    }
}
