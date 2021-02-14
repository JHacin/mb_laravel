<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\CatLocation;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;

use Tests\Browser\Admin\Pages\AdminCatListPage;
use Tests\Browser\Admin\Pages\AdminCatLocationEditPage;
use Throwable;

class AdminCatListTest extends AdminTestCase
{
    protected static ?Cat $sampleCat_1 = null;
    protected static ?Cat $sampleCat_2 = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleCat_1 || !static::$sampleCat_2) {
            static::$sampleCat_1 = $this->createCat(['name' => 'a_' . time(), 'location_id' => CatLocation::factory()]);
            static::$sampleCat_2 = $this->createCat(['name' => 'b_' . time(), 'location_id' => CatLocation::factory()]);
        }
    }

    /**
     * @throws Throwable
     */
    public function test_cat_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $cat = static::$sampleCat_2;
            $this->goToCatsListPage($browser);
            $this->openFirstRowDetails($browser);

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
     * @throws Throwable
     */
    public function test_clicking_on_location_opens_up_location_edit_form()
    {
        $this->browse(function (Browser $browser) {
            $cat = static::$sampleCat_2;
            $this->goToCatsListPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($cat) {
                $browser
                    ->click('tr[data-dt-column="6"] a')
                    ->on(new AdminCatLocationEditPage($cat->location));
            });
        });
    }

    /**
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
     * @throws Throwable
     */
    public function test_filters_by_location()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);

            $browser->with('#bp-filters-navbar li[filter-name="location_id"]', function (Browser $browser) {
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
     * @throws Throwable
     */
    public function test_shows_gender_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);

            $browser->with('#bp-filters-navbar li[filter-name="gender"]', function (Browser $browser) {
                $browser->click('a.dropdown-toggle');

                foreach (Cat::GENDER_LABELS as $key => $label) {
                    $browser->assertSee($label);
                }
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_filters_by_gender()
    {
        $this->browse(function (Browser $b) {
            static::$sampleCat_1->update(['gender' => Cat::GENDER_MALE]);
            static::$sampleCat_1->refresh();
            static::$sampleCat_2->update(['gender' => Cat::GENDER_FEMALE]);
            static::$sampleCat_2->refresh();

            $this->goToCatsListPage($b);

            $b->with('#bp-filters-navbar li[filter-name="gender"]', function (Browser $b) {
                $selectedOption = static::$sampleCat_1->gender;
                $b->click('a.dropdown-toggle');
                $b->click(".dropdown-item[dropdownkey='$selectedOption']");

            });

            $this->waitForRequestsToFinish($b);

            $b->with('@crud-table-body', function (Browser $b) {
                $b->assertSee(static::$sampleCat_1->name);
                $b->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_is_active_filter_options()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);
            $this->assertSeeBooleanTypeFilter($browser, '#bp-filters-navbar li[filter-name="is_active"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_filters_by_is_group()
    {
        $this->browse(function (Browser $b) {
            static::$sampleCat_1->update(['is_group' => true]);
            static::$sampleCat_1->refresh();
            static::$sampleCat_2->update(['is_group' => false]);
            static::$sampleCat_2->refresh();

            $this->goToCatsListPage($b);
            $this->clickBooleanTypeFilterValue($b, '#bp-filters-navbar li[filter-name="is_group"]', true);

            $b->with('@crud-table-body', function (Browser $b) {
                $b->assertSee(static::$sampleCat_1->name);
                $b->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
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
            $this->clickBooleanTypeFilterValue($browser, '#bp-filters-navbar li[filter-name="is_active"]', true);

            $browser->with('@crud-table-body', function (Browser $browser) {
                $browser
                    ->assertSee(static::$sampleCat_1->name)
                    ->assertDontSee(static::$sampleCat_2->name);
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_search_works()
    {
        $this->browse(function (Browser $browser) {
            $this->goToCatsListPage($browser);

            $searches = [
                static::$sampleCat_1->name,
                static::$sampleCat_1->location->name
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);

                $browser->with('@crud-table-body', function (Browser $browser) {
                    $browser
                        ->assertSee(static::$sampleCat_1->name)
                        ->assertDontSee(static::$sampleCat_2->name);
                });
            }
        });
    }

    /**
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
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminCatListPage);

        $this->waitForRequestsToFinish($browser);
        $this->clearActiveFilters($browser);
    }
}
