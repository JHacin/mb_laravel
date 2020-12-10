<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use App\Models\Sponsorship;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorListPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Throwable;

class AdminSponsorListTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_person_data_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $personData = $this->createPersonDataWithSponsorships();
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($personData) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $personData->id,
                    1 => $personData->email,
                    2 => $personData->first_name,
                    3 => $personData->last_name,
                    4 => $personData->city,
                    5 => $this->formatToDateColumnString($personData->created_at),
                    6 => $personData->is_confirmed ? 'Da' : 'Ne',
                    7 => $personData->sponsorships()->count() . ' botrovanj',
                    8 => $personData->unscopedSponsorships()->count() . ' botrovanj',
                ]);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_is_confirmed_filter()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->assertSeeBooleanTypeFilter($browser, '@sponsors-list-is-confirmed-filter');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_confirmed()
    {
        $this->browse(function (Browser $browser) {
            $confirmed = $this->createPersonData(['is_confirmed' => true]);
            $unconfirmed = $this->createPersonData(['is_confirmed' => false]);
            $this->goToPage($browser);
            $this->clickBooleanTypeFilterValue($browser, '@sponsors-list-is-confirmed-filter', true);
            $browser->with('@crud-table-body', function (Browser $browser) use ($confirmed, $unconfirmed) {
                $browser
                    ->assertSee($confirmed->email)
                    ->assertDontSee($unconfirmed->email);
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
            $searched = $this->createPersonData();
            $ignored = $this->createPersonData();

            $this->goToPage($browser);

            $searches = [
                $searched->id,
                $searched->email,
                $searched->first_name,
                $searched->last_name,
                $searched->city,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);

                $browser->with('@crud-table-body', function (Browser $browser) use ($searched, $ignored) {
                    $browser
                        ->assertSee($searched->email)
                        ->assertDontSee($ignored->email);
                });
            }
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_active_sponsorships_links_works()
    {
        $this->browse(function (Browser $browser) {
            $personData = $this->createPersonDataWithSponsorships();
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) {
                $browser
                    ->click('@related-sponsorships-link')
                    ->on(new AdminSponsorshipListPage);
            });

            $this->waitForRequestsToFinish($browser);

            $browser
                ->assertQueryStringHas('personData', $personData->id)
                ->assertQueryStringHas('is_active', 1)
                ->assertSee(
                    'Prikazanih 1 do ' .
                    $personData->sponsorships()->count() .
                    ' od ' .
                    $personData->sponsorships()->count() .
                    ' vnosov'
                );
        });
    }
    /**
     * @return void
     * @throws Throwable
     */
    public function test_clicking_all_sponsorships_links_works()
    {
        $this->browse(function (Browser $browser) {
            $personData = $this->createPersonDataWithSponsorships();
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) {
                $browser
                    ->click('@related-unscopedSponsorships-link')
                    ->on(new AdminSponsorshipListPage);
            });

            $this->waitForRequestsToFinish($browser);

            $browser
                ->assertQueryStringHas('personData', $personData->id)
                ->assertQueryStringMissing('is_active')
                ->assertSee(
                    'Prikazanih 1 do ' .
                    $personData->unscopedSponsorships()->count() .
                    ' od ' .
                    $personData->unscopedSponsorships()->count() .
                    ' vnosov'
                );
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_cancel_all_sponsorships_button_if_active_sponsorships_exist()
    {
        $this->browse(function (Browser $browser) {
            $this->createPersonDataWithSponsorships();
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) {
                $browser->assertPresent('@sponsor-cancel-all-sponsorships-form-button');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_doesnt_show_cancel_all_sponsorships_button_if_active_sponsorships_dont_exist()
    {
        $this->browse(function (Browser $browser) {
            PersonData::factory()
                ->has(Sponsorship::factory()->count(2)->state(['is_active' => false]))
                ->createOne();

            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) {
                $browser->assertMissing('@sponsor-cancel-all-sponsorships-form-button');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_cancels_all_sponsorships()
    {
        $this->browse(function (Browser $browser) {
            $sponsor = $this->createPersonDataWithSponsorships();
            $this->assertTrue($sponsor->sponsorships()->count() > 0);
            $this->goToPage($browser);

            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) {
                $browser->click('@sponsor-cancel-all-sponsorships-form-button');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Prekliči');
            });
            $this->waitForRequestsToFinish($browser);
            $sponsor->refresh();
            $this->assertTrue($sponsor->sponsorships()->count() > 0);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) {
                $browser->click('@sponsor-cancel-all-sponsorships-form-button');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Potrdi');
            });
            $this->waitForRequestsToFinish($browser);
            $sponsor->refresh();
            $this->assertTrue($sponsor->sponsorships()->count() === 0);
            $browser->assertSee('Vsa aktivna botrovanja so bila uspešno prekinjena.');
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsor) {
                $this->assertDetailsModalColumnShowsValue($browser, 7, '0 botrovanj');
                $this->assertDetailsModalColumnShowsValue($browser, 8, $sponsor->unscopedSponsorships()->count() . ' botrovanj');
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_deletes_person_data()
    {
        $this->browse(function (Browser $browser) {
            $personData = $this->createPersonData(['first_name' => 'DELETE_ME']);
            $this->goToPage($browser);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) use ($personData) {
                $browser
                    ->assertSee($personData->first_name)
                    ->click('a[data-button-type="delete"]');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Izbriši');
            });
            $this->waitForRequestsToFinish($browser);
            $browser->assertDontSee($personData->first_name);
            $this->assertDatabaseMissing('person_data', ['id' => $personData->id]);
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
            ->visit(new AdminSponsorListPage);

        $this->waitForRequestsToFinish($browser);
        $this->clearActiveFilters($browser);
    }
}
