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
    /**
     * @throws Throwable
     */
    public function test_cat_details_are_shown_correctly()
    {
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();
            $this->goToCatsListPage($b);
            $this->openFirstRowDetails($b);

            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($cat) {
                $this->assertDetailsModalShowsValuesInOrder($b, [
                    0 => $cat->id,
                    2 => $cat->name,
                    3 => $cat->status_label,
                    4 => $cat->gender_label,
                    5 => $this->formatToDateColumnString($cat->date_of_arrival_mh),
                    6 => $this->formatToDateColumnString($cat->date_of_arrival_boter),
                    7 => $cat->location->name ?? '',
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
        $this->browse(function (Browser $b) {
            $cat = $this->createCat();
            $this->goToCatsListPage($b);
            $this->openFirstRowDetails($b);

            $b->whenAvailable('@data-table-row-details-modal', function (Browser $b) use ($cat) {
                $b
                    ->click('tr[data-dt-column="7"] a')
                    ->on(new AdminCatLocationEditPage($cat->location));
            });
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_location_filter_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToCatsListPage($b);
            $b->assertSelectHasOptions('filter_locationId', CatLocation::pluck('id')->toArray());
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_gender_filter_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToCatsListPage($b);
            $this->assertFilterDropdownHasValues($b, 'gender', Cat::GENDERS);
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_is_group_filter_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToCatsListPage($b);
            $this->assertSeeBooleanTypeFilter($b, '#bp-filters-navbar li[filter-name="is_group"]');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_shows_status_filter_options()
    {
        $this->browse(function (Browser $b) {
            $this->goToCatsListPage($b);
            $this->assertFilterDropdownHasValues($b, 'status', Cat::STATUSES);
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
