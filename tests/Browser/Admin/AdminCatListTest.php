<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\CatLocation;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatListPage;
use Throwable;

class AdminCatListTest extends AdminTestCase
{
    /**
     * @var Cat
     */
    protected static $sampleCat_1;

    /**
     * @var Cat
     */
    protected static $sampleCat_2;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleCat_1 || !static::$sampleCat_2) {
            static::$sampleCat_1 = $this->createCat();
            static::$sampleCat_2 = $this->createCat();
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_cat_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $cat = static::$sampleCat_2;
            $this->goToCatsListPage($browser);

            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) {
                $this->resizeToMediumScreen($browser);
                $browser->click('@data-table-open-row-details');
            });

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($cat) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $cat->id,
                    2 => $cat->name,
                    3 => $cat->gender_label,
                    4 => $this->formatToDateColumnString($cat->date_of_arrival_mh),
                    5 => $this->formatToDateColumnString($cat->date_of_arrival_boter),
                    6 => $cat->location->name ?? '',
                    7 => $cat->is_active ? 'Da' : 'Ne',
                    8 => $this->formatToDatetimeColumnString($cat->created_at),
                    9 => $this->formatToDatetimeColumnString($cat->updated_at),
                ]);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_location_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);
            $browser->assertSelectHasOptions('filter_locationId', CatLocation::pluck('id')->toArray());
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_location()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-location-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->select('filter_locationId', static::$sampleCat_1->location_id);
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_gender_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-gender-filter', function (Browser $browser) {
                $browser->click('a.dropdown-toggle');

                foreach (Cat::GENDER_LABELS as $key => $label) {
                    $browser->assertSee($label);
                }
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_filters_by_gender()
    {
        $this->browse(function (Browser $browser) {
            static::$sampleCat_1->update(['gender' => Cat::GENDER_MALE]);
            static::$sampleCat_1->refresh();
            static::$sampleCat_2->update(['gender' => Cat::GENDER_FEMALE]);
            static::$sampleCat_2->refresh();

            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-gender-filter', function (Browser $browser) {
                $selectedOption = static::$sampleCat_1->gender;

                $browser
                    ->click('a.dropdown-toggle')
                    ->click(".dropdown-item[dropdownkey='$selectedOption']");
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
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
            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-is-active-filter', function (Browser $browser) {
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
            static::$sampleCat_1->update(['is_active' => true]);
            static::$sampleCat_1->refresh();
            static::$sampleCat_2->update(['is_active' => false]);
            static::$sampleCat_2->refresh();

            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-is-active-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->click('.dropdown-item[dropdownkey="1"]');
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_searches_by_id()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);
            $this->enterSearchInputValue($browser, static::$sampleCat_1->id);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_searches_by_name()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);
            $this->enterSearchInputValue($browser, static::$sampleCat_1->name);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_searches_by_location_name()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);
            $this->enterSearchInputValue($browser, static::$sampleCat_1->location->name);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_deletes_cat()
    {
        $this->browse(function (Browser $browser) {
            $cat = $this->createCat(['name' => 'DELETE_ME']);
            $this->goToCatsListPage($browser);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) use ($cat) {
                $browser
                    ->assertSee($cat->name)
                    ->click('a[data-button-type="delete"]');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Izbriši');
            });
            $this->waitForRequestsToFinish($browser);
            $browser->assertDontSee($cat->name);
            $this->assertDatabaseMissing('cats', ['id' => $cat->id]);
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToCatsListPage(Browser $browser)
    {
        $browser
            ->loginAs(self::$defaultAdmin)
            ->visit(new AdminCatListPage);

        $this->waitForRequestsToFinish($browser);
        $this->clearActiveFilters($browser);
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function clearActiveFilters(Browser $browser)
    {
        $browser->click('@crud-clear-filters-link');
        $this->waitForRequestsToFinish($browser);
    }

    /**
     * @param Browser $browser
     * @param string|int $value
     */
    protected function enterSearchInputValue(Browser $browser, $value)
    {
        $browser->type('@data-table-search-input', $value);
        $browser->pause(1000);
    }
}
