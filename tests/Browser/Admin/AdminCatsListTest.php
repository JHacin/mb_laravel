<?php

namespace Tests\Browser\Admin;

use App\Models\Cat;
use App\Models\CatLocation;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatListPage;
use Throwable;

class AdminCatsListTest extends AdminTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function test_cat_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $cat = $this->createCat();

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
            $location = $this->createCatLocation();
            $cat = $this->createCat(['location_id' => $location]);
            $catWithoutLocation = $this->createCat();

            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-location-filter', function (Browser $browser) use ($location) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->select('filter_locationId', $location->id);
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) use ($cat, $catWithoutLocation) {
                $browser
                    ->assertSee($cat->name)
                    ->assertDontSee($catWithoutLocation->name);
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
            $maleCat = $this->createCat(['gender' => Cat::GENDER_MALE]);
            $femaleCat = $this->createCat(['gender' => Cat::GENDER_FEMALE]);

            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-gender-filter', function (Browser $browser) use ($maleCat) {
                $selectedOption = $maleCat->gender;

                $browser
                    ->click('a.dropdown-toggle')
                    ->click(".dropdown-item[dropdownkey='$selectedOption']");
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) use ($maleCat, $femaleCat) {
                $browser
                    ->assertSee($maleCat->name)
                    ->assertDontSee($femaleCat->name);
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
            $activeCat = $this->createCat(['is_active' => true]);
            $inactiveCat = $this->createCat(['is_active' => false]);

            $this->goToCatsListPage($browser);

            $browser->with('@cats-list-is-active-filter', function (Browser $browser) {
                $browser
                    ->click('a.dropdown-toggle')
                    ->click('.dropdown-item[dropdownkey="1"]');
            });

            $this->waitForRequestsToFinish($browser);

            $browser->with('@crud-table-body', function (Browser $browser) use ($activeCat, $inactiveCat) {
                $browser
                    ->assertSee($activeCat->name)
                    ->assertDontSee($inactiveCat->name);
            });
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
        $filterClearButton = $browser->element('@data-table-filter-clear-visible');

        if ($filterClearButton) {
            $filterClearButton->click();
            $this->waitForRequestsToFinish($browser);
        }
    }
}
