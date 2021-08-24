<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use App\Models\Sponsorship;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminSponsorListPage;
use Tests\Browser\Admin\Pages\AdminSponsorshipListPage;
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
                    6 => $personData->sponsorships()->count() . ' botrstev',
                    7 => $personData->unscopedSponsorships()->count() . ' botrstev',
                ]);
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
            $searched = $this->createPersonData([
                'email' => 'a_email' . time() . '@example.com',
                'first_name' => 'a_first_name' . time(),
                'last_name' => 'a_last_name' . time(),
                'city' => 'a_city' . time(),
            ]);
            $ignored = $this->createPersonData([
                'email' => 'b_email' . time() . '@example.com',
                'first_name' => 'b_first_name' . time(),
                'last_name' => 'b_last_name' . time(),
                'city' => 'b_city' . time(),
            ]);

            $this->goToPage($browser);

            $searches = [
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
            $browser->assertSee('Vsa aktivna botrstva so bila uspešno prekinjena.');
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsor) {
                $this->assertDetailsModalColumnShowsValue($browser, 6, '0 botrstev');
                $this->assertDetailsModalColumnShowsValue($browser, 7, $sponsor->unscopedSponsorships()->count() . ' botrstev');
            });
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
