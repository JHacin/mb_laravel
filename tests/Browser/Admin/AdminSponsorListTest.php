<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorListPage;
use Throwable;

class AdminSponsorListTest extends AdminTestCase
{
    /**
     * @var PersonData|null
     */
    protected static ?PersonData $samplePersonData_1 = null;

    /**
     * @var PersonData|null
     */
    protected static ?PersonData $samplePersonData_2 = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$samplePersonData_1 || !static::$samplePersonData_2) {
            static::$samplePersonData_1 = $this->createPersonData();
            static::$samplePersonData_2 = $this->createPersonData();
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_person_data_details_are_shown_correctly()
    {
        $this->browse(function (Browser $browser) {
            $personData = static::$samplePersonData_2;
            $this->goToPage($browser);
            $this->openFirstRowDetails($browser);

            $browser->whenAvailable('@data-table-row-details-modal', function (Browser $browser) use ($personData) {
                $this->assertDetailsModalShowsValuesInOrder($browser, [
                    0 => $personData->id,
                    1 => $personData->email,
                    2 => $personData->first_name,
                    3 => $personData->last_name,
                    4 => $personData->gender_label,
                    5 => $personData->address,
                    6 => $personData->city,
                    7 => $this->formatToDateColumnString($personData->created_at),
                    8 => $this->formatToDatetimeColumnString($personData->updated_at),
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
            $this->goToPage($browser);

            $searches = [
                static::$samplePersonData_2->id,
                static::$samplePersonData_2->email,
                static::$samplePersonData_2->first_name,
                static::$samplePersonData_2->last_name,
                static::$samplePersonData_2->address,
                static::$samplePersonData_2->city,
            ];

            foreach ($searches as $value) {
                $this->enterSearchInputValue($browser, $value);

                $browser->with('@crud-table-body', function (Browser $browser) {
                    $browser
                        ->assertSee(static::$samplePersonData_2->email)
                        ->assertDontSee(static::$samplePersonData_1->email);
                });
            }
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
