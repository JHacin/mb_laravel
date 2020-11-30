<?php

namespace Tests\Browser;

use App\Models\CatLocation;
use App\Utilities\CountryList;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\AdminTestCase;
use Tests\Browser\Pages\Admin\AdminCatLocationListPage;
use Throwable;

class AdminCatLocationListTest extends AdminTestCase
{
    /**
     * @var CatLocation|null
     */
    protected static ?CatLocation $sampleLocation_1 = null;

    /**
     * @var CatLocation|null
     */
    protected static ?CatLocation $sampleLocation_2 = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$sampleLocation_1 || !static::$sampleLocation_2) {
            static::$sampleLocation_1 = $this->createCatLocation([
                'name' => 'Veterina MH',
                'address' => 'Bernekerjeva 43',
                'zip_code' => '1000',
                'city' => 'Ljubljana',
                'country' => CountryList::DEFAULT,
            ]);
            static::$sampleLocation_2 = $this->createCatLocation([
                'name' => 'Asdfghe',
                'address' => 'Random street 99989',
                'zip_code' => '565656',
                'city' => 'Townsville',
                'country' => 'AO',
            ]);
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_location_details()
    {
        $this->browse(function (Browser $browser) {
            $location = static::$sampleLocation_2;
            $this->goToCatLocationsListPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($location) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $location->id,
                    1 => $location->name,
                    2 => $location->address,
                    3 => $location->zip_code,
                    4 => $location->city,
                    5 => CountryList::COUNTRY_NAMES[$location->country],
                    6 => $this->formatToDatetimeColumnString($location->created_at),
                    7 => $this->formatToDatetimeColumnString($location->updated_at),
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
            $this->goToCatLocationsListPage($browser);

            $searches = [
                static::$sampleLocation_1->id,
                static::$sampleLocation_1->name,
                static::$sampleLocation_1->address,
                static::$sampleLocation_1->zip_code,
                static::$sampleLocation_1->city,
                CountryList::COUNTRY_NAMES[static::$sampleLocation_1->country]
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);
                $browser->with('@crud-table-body', function (Browser $browser) {
                    $browser
                        ->assertSee(static::$sampleLocation_1->name)
                        ->assertDontSee(static::$sampleLocation_2->name);
                });
            }
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_deletes_location()
    {
        $this->browse(function (Browser $browser) {
            $location = $this->createCatLocation(['name' => 'DELETE_ME']);
            $this->goToCatLocationsListPage($browser);
            $browser->with($this->getTableRowSelectorForIndex(1), function (Browser $browser) use ($location) {
                $browser
                    ->assertSee($location->name)
                    ->click('a[data-button-type="delete"]');
            });
            $browser->whenAvailable('.swal-overlay.swal-overlay--show-modal', function (Browser $browser) {
                $browser->press('Izbriši');
            });
            $this->waitForRequestsToFinish($browser);
            $browser->assertDontSee($location->name);
            $this->assertDatabaseMissing('cat_locations', ['id' => $location->id]);
        });
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function goToCatLocationsListPage(Browser $browser)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminCatLocationListPage);

        $this->waitForRequestsToFinish($browser);
        $this->clearActiveFilters($browser);
    }
}
