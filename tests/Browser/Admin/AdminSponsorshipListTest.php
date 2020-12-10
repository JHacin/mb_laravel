<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Tests\Browser\Pages\Admin\AdminUserEditPage;
use Throwable;

class AdminSponsorshipListTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_sponsorship_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship([
                'monthly_amount' => 99,
                'is_anonymous' => true,
                'is_active' => false,
                'ended_at' => '2019-08-21'
            ]);
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $sponsorship->id,
                    1 => $sponsorship->cat->name_and_id,
                    2 => $sponsorship->personData->email_and_user_id,
                    3 => '99,00 €',
                    4 => 'Da',
                    5 => 'Ne',
                    6 => $this->formatToDatetimeColumnString($sponsorship->created_at),
                    7 => '21. 8. 2019',
                    8 => $this->formatToDatetimeColumnString($sponsorship->updated_at),
                ]);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_inactive_sponsorships()
    {
        $this->browse(function (Browser $browser) {
            $inactive = $this->createSponsorship(['is_active' => false]);
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($inactive) {
                $this->assertDetailsModalColumnShowsValue($browser, 0, $inactive->id);
                $this->assertDetailsModalColumnShowsValue($browser, 5, 'Ne');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_on_cat_opens_up_cat_edit_form()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $browser
                    ->click('tr[data-dt-column="1"] a')
                    ->on(new AdminCatEditPage($sponsorship->cat));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_on_anon_sponsor_opens_up_person_data_edit_form()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship();
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $browser
                    ->click('tr[data-dt-column="2"] a')
                    ->on(new AdminSponsorEditPage($sponsorship->personData));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_on_registered_sponsor_opens_up_user_edit_form()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship(['person_data_id' => $this->createUser()->personData->id]);
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $browser
                    ->click('tr[data-dt-column="2"] a')
                    ->on(new AdminUserEditPage($sponsorship->personData->user));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_cat_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser->assertSelectHasOptions('filter_cat', Cat::pluck('id')->toArray());
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_cat()
    {
        $this->browse(function (Browser $browser) {
            $shown = $this->createSponsorship();
            $hidden = $this->createSponsorship();
            $this->goToPage($browser);

            $browser->with('@sponsorship-list-location-filter', function (Browser $browser) use ($shown) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->select('filter_cat', $shown->cat_id);
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) use ($shown, $hidden) {
                $browser
                    ->assertSee($shown->cat->name_and_id)
                    ->assertDontSee($hidden->cat->name_and_id);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_person_data_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser->assertSelectHasOptions('filter_personData', PersonData::pluck('id')->toArray());
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_person_data()
    {
        $this->browse(function (Browser $browser) {
            $shown = $this->createSponsorship();
            $hidden = $this->createSponsorship();
            $this->goToPage($browser);
            $browser->with('@sponsorship-list-person-data-filter', function (Browser $browser) use ($shown) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->select('filter_personData', $shown->person_data_id);
            });
            $this->waitForRequestsToFinish($browser);
            $browser->with('@crud-table-body', function (Browser $browser) use ($shown, $hidden) {
                $browser
                    ->assertSee($shown->personData->email_and_user_id)
                    ->assertDontSee($hidden->personData->email_and_user_id);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_is_active_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $browser->with('@sponsorship-list-is-active-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->assertSee('Da')
                    ->assertSee('Ne');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_is_active()
    {
        $this->browse(function (Browser $browser) {
            $this->createSponsorship([
                'is_active' => true,
                'monthly_amount' => 5432,
            ]);
            $this->createSponsorship([
                'is_active' => false,
                'monthly_amount' => 9876,
            ]);
            $this->goToPage($browser);
            $browser->with('@sponsorship-list-is-active-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->click('.dropdown-item[dropdownkey="1"]');
            });
            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee('5.432,00 €')
                    ->assertDontSee('9.876,00 €');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_search_works()
    {
        $this->browse(function (Browser $browser) {
            $shown = $this->createSponsorship(['monthly_amount' => 987]);
            $hidden = $this->createSponsorship();
            $this->goToPage($browser);

            $searches = [
                $shown->id,
                $shown->cat->id,
                $shown->cat->name,
                $shown->personData->id,
                $shown->personData->email,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);
                $browser->with('@crud-table-body', function (Browser $browser) use ($shown, $hidden) {
                    $browser
                        ->assertSee($shown->cat->name_and_id)
                        ->assertDontSee($hidden->cat->name_and_id);
                });
            }
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_cancel_button_if_sponsorship_is_active()
    {
        $this->browse(function (Browser $browser) {
            $this->createSponsorship(['is_active' => true]);
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) {
                $browser->assertPresent('@sponsorship-cancel-form-button');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_doesnt_show_cancel_button_if_sponsorship_is_not_active()
    {
        $this->browse(function (Browser $browser) {
            $this->createSponsorship(['is_active' => false]);
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) {
                $browser->assertMissing('@sponsorship-cancel-form-button');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_cancels_sponsorship()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship(['is_active' => true]);
            $this->assertTrue((bool)$sponsorship->is_active);
            $this->goToPage($browser);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) {
                $browser->click('@sponsorship-cancel-form-button');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Prekliči');
            });
            $this->waitForRequestsToFinish($browser);
            $sponsorship->refresh();
            $this->assertTrue((bool)$sponsorship->is_active);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) {
                $browser->click('@sponsorship-cancel-form-button');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Potrdi');
            });
            $this->waitForRequestsToFinish($browser);
            $sponsorship->refresh();
            $this->assertFalse((bool)$sponsorship->is_active);
            $this->assertNotNull($sponsorship->ended_at);
            $browser->assertSee('Botrovanje uspešno prekinjeno.');
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $this->assertDetailsModalColumnShowsValue($browser, 5, 'Ne');
                $this->assertDetailsModalColumnShowsValue($browser, 7,
                    $this->formatToDateColumnString($sponsorship->ended_at));
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_deletes_sponsorship()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = $this->createSponsorship();
            $catNameAndId = $sponsorship->cat->name_and_id;
            $this->goToPage($browser);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) use ($catNameAndId) {
                $browser
                    ->assertSee($catNameAndId)
                    ->click('a[data-button-type="delete"]');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Izbriši');
            });
            $this->waitForRequestsToFinish($browser);
            $browser->assertDontSee($catNameAndId);
            $this->assertDatabaseMissing('sponsorships', ['id' => $sponsorship->id]);
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorshipListPage);
        $this->waitForRequestsToFinish($browser);
        $this->clearActiveFilters($browser);
    }
}
