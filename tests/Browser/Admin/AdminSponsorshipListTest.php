<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminCatEditPage;
use Tests\Browser\Admin\Pages\AdminSponsorEditPage;
use Tests\Browser\Admin\Pages\AdminSponsorshipListPage;
use Throwable;

class AdminSponsorshipListTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_sponsorship_details_are_shown_correctly()
    {
        $this->browse(function (Browser $b) {
            $sponsorship = $this->createSponsorship([
                'monthly_amount' => 99,
                'is_anonymous' => true,
                'is_active' => false,
                'ended_at' => '2019-08-21'
            ]);
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($sponsorship) {
                $this->assertDetailsModalShowsValuesInOrder($b, [
                    0 => $sponsorship->id,
                    1 => $sponsorship->payment_reference_number,
                    2 => $sponsorship->cat->name_and_id,
                    3 => $sponsorship->personData->email_and_id,
                    4 => '99,00 €',
                    5 => 'Da',
                    6 => 'Ne',
                    7 => $this->formatToDatetimeColumnString($sponsorship->created_at),
                    8 => '21. 8. 2019',
                    9 => $this->formatToDatetimeColumnString($sponsorship->updated_at),
                ]);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_inactive_sponsorships()
    {
        $this->browse(function (Browser $b) {
            $inactive = $this->createSponsorship(['is_active' => false]);
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($inactive) {
                $this->assertDetailsModalColumnShowsValue($b, 0, $inactive->id);
                $this->assertDetailsModalColumnShowsValue($b, 5, 'Ne');
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_on_cat_opens_up_cat_edit_form()
    {
        $this->browse(function (Browser $b) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($sponsorship) {
                $b
                    ->click('tr[data-dt-column="2"] a')
                    ->on(new AdminCatEditPage($sponsorship->cat));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_clicking_on_sponsor_opens_up_person_data_edit_form()
    {
        $this->browse(function (Browser $b) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($sponsorship) {
                $b
                    ->click('tr[data-dt-column="3"] a')
                    ->on(new AdminSponsorEditPage($sponsorship->personData));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_correct_filter_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $b->assertSelectHasOptions('filter_cat', Cat::pluck('id')->toArray());
            $b->assertSelectHasOptions('filter_personData', PersonData::pluck('id')->toArray());
            $this->assertSeeBooleanTypeFilter($b, '@sponsorship-list-is-active-filter');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_cancel_button_if_sponsorship_is_active()
    {
        $this->browse(function (Browser $b) {
            $this->createSponsorship(['is_active' => true]);
            $this->goToPage($b);
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) {
                $b->assertPresent('@sponsorship-cancel-form-button');
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_doesnt_show_cancel_button_if_sponsorship_is_not_active()
    {
        $this->browse(function (Browser $browser) {
            $this->createSponsorship(['is_active' => false]);
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $b) {
                $b->assertMissing('@sponsorship-cancel-form-button');
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_cancels_sponsorship()
    {
        $this->browse(function (Browser $b) {
            $sponsorship = $this->createSponsorship(['is_active' => true]);
            $this->assertTrue((bool)$sponsorship->is_active);
            $this->goToPage($b);
            $b->with($this->getTableRowSelectorForIndex(1), function (Browser $b) {
                $b->click('@sponsorship-cancel-form-button');
            });
            $b->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $b) {
                $b->press('Prekliči');
            });
            $this->waitForRequestsToFinish($b);
            $sponsorship->refresh();
            $this->assertTrue((bool)$sponsorship->is_active);
            $b->with($this->getTableRowSelectorForIndex(1), function (Browser $b) {
                $b->click('@sponsorship-cancel-form-button');
            });
            $b->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $b) {
                $b->press('Potrdi');
            });
            $this->waitForRequestsToFinish($b);
            $sponsorship->refresh();
            $this->assertFalse((bool)$sponsorship->is_active);
            $this->assertNotNull($sponsorship->ended_at);
            $b->assertSee('Botrovanje uspešno prekinjeno.');
            $this->openFirstRowDetails($b);
            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($sponsorship) {
                $this->assertDetailsModalColumnShowsValue($b, 5, 'Ne');
                $this->assertDetailsModalColumnShowsValue($b, 7,
                    $this->formatToDateColumnString($sponsorship->ended_at));
            });
        });
    }

    /**
     * @param Browser $b
     * @throws TimeoutException
     */
    protected function goToPage(Browser $b)
    {
        $b->loginAs(static::$defaultAdmin);
        $b->visit(new AdminSponsorshipListPage);
        $this->waitForRequestsToFinish($b);
        $this->clearActiveFilters($b);
    }
}
