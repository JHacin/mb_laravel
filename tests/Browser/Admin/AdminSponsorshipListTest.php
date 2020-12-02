<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\PersonData;
use App\Models\Sponsorship;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatEditPage;
use Tests\Browser\Pages\Admin\AdminPersonDataEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorshipListPage;
use Tests\Browser\Pages\Admin\AdminUserEditPage;
use Throwable;

class AdminSponsorshipListTest extends AdminTestCase
{
    /**
     * @var Sponsorship|null
     */
    protected static ?Sponsorship $sampleSponsorship_1 = null;

    /**
     * @var Sponsorship|null
     */
    protected static ?Sponsorship $sampleSponsorship_2 = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleSponsorship_1 || !static::$sampleSponsorship_2) {
            static::$sampleSponsorship_1 = $this->createSponsorship();
            static::$sampleSponsorship_2 = $this->createSponsorship();
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_sponsorship_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $sponsorship = static::$sampleSponsorship_2;
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $sponsorship->id,
                    1 => $sponsorship->cat->name_and_id,
                    2 => $sponsorship->personData->email_and_user_id,
                    3 => number_format($sponsorship->monthly_amount, 2, ',', '.') . ' €',
                    4 => $sponsorship->is_anonymous ? 'Da' : 'Ne',
                    5 => $sponsorship->is_active ? 'Da' : 'Ne',
                    6 => $this->formatToDatetimeColumnString($sponsorship->created_at),
                    7 => $this->formatToDatetimeColumnString($sponsorship->ended_at),
                    8 => $this->formatToDatetimeColumnString($sponsorship->updated_at),
                ]);
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
            $sponsorship = static::$sampleSponsorship_2;
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
            $sponsorship = static::$sampleSponsorship_2;

            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($sponsorship) {
                $browser
                    ->click('tr[data-dt-column="2"] a')
                    ->on(new AdminPersonDataEditPage($sponsorship->personData));
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
            $sponsorship = static::$sampleSponsorship_2;
            $sponsorship->update(['person_data_id' => $this->createUser()->personData->id]);
            $sponsorship->refresh();

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
            $this->goToPage($browser);

            $browser->with('@sponsorship-list-location-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->select('filter_cat', static::$sampleSponsorship_1->cat_id);
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleSponsorship_1->cat->name_and_id)
                    ->assertDontSee(static::$sampleSponsorship_2->cat->name_and_id);
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
            $this->goToPage($browser);

            $browser->with('@sponsorship-list-person-data-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->select('filter_personData', static::$sampleSponsorship_1->person_data_id);
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleSponsorship_1->personData->email_and_user_id)
                    ->assertDontSee(static::$sampleSponsorship_2->personData->email_and_user_id);
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
            static::$sampleSponsorship_1->update(['monthly_amount' => 987]);
            $this->goToPage($browser);

            $searches = [
                static::$sampleSponsorship_1->id,
                static::$sampleSponsorship_1->cat->id,
                static::$sampleSponsorship_1->cat->name,
                static::$sampleSponsorship_1->personData->id,
                static::$sampleSponsorship_1->personData->email,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);

                $browser->with('@crud-table-body', function (Browser $browser) {
                    $browser
                        ->assertSee(static::$sampleSponsorship_1->cat->name_and_id)
                        ->assertDontSee(static::$sampleSponsorship_2->cat->name_and_id);
                });
            }
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
