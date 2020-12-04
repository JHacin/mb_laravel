<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminPersonDataAddPage;
use Tests\Browser\Pages\Admin\AdminPersonDataListPage;
use Throwable;

class AdminPersonDataAddTest extends AdminTestCase
{

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $this->submit($browser);
            $this->assertAllRequiredErrorsAreShown($browser, ['@email-input-wrapper']);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email_field()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('email', 'sdfdsfds');
            $this->submit($browser);
            $browser->assertSee('Vrednost mora biti veljaven email naslov.');

            $this->goToPage($browser);
            $browser->type('email', static::$sampleUser->email);
            $this->submit($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            /** @var PersonData $existingPersonData */
            $existingPersonData = PersonData::inRandomOrder()->first();
            $this->goToPage($browser);
            $browser->type('email', $existingPersonData->email);
            $this->submit($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            $this->goToPage($browser);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->submit($browser);
            $browser->assertSee('Vnos uspešen.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_date_of_birth_is_in_the_past()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);

            $this->disableHtmlFormValidation($browser);

            $browser->with('@date_of_birth-input-wrapper', function (Browser $browser) {
                $browser->click('input[type="text"]');
            });

            $browser->with('.datepicker', function (Browser $browser) {
                $browser
                    ->click('.datepicker-days thead th.next')
                    ->click('.datepicker-days thead th.next')
                    ->click('.datepicker-days tbody > tr > td');
            });

            $this->submit($browser);
            $browser->assertSee('Datum rojstva mora biti v preteklosti.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_adding_person_data_works()
    {
        $this->browse(function (Browser $browser) {
            /** @var PersonData $personData */
            $personData = PersonData::factory()->makeOne();

            $this->goToPage($browser);

            $browser
                ->type('email', $personData->email)
                ->type('first_name', $personData->first_name)
                ->type('last_name', $personData->last_name);

            $browser->with('@gender-input-wrapper', function (Browser $browser) use ($personData) {
                $browser->click('input[value="' . $personData->gender . '"]');
            });

            $browser->type('phone', $personData->phone);

            $browser->with('@date_of_birth-input-wrapper', function (Browser $browser) {
                $browser->click('input[type="text"]');
            });

            $browser->with('.datepicker', function (Browser $browser) {
                $browser
                    ->click('.datepicker-days thead th.prev')
                    ->click('.datepicker-days thead th.prev')
                    ->click('.datepicker-days tbody > tr > td');
            });

            $browser
                ->type('address', $personData->address)
                ->type('zip_code', $personData->zip_code)
                ->type('city', $personData->city)
                ->select('country', $personData->country);

            $this->submit($browser);

            $browser->assertSee('Vnos uspešen.');

            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal',
                function (Browser $browser) use ($personData) {
                    $this->assertDetailsModalShowsValuesInOrder($browser, [
                        1 => $personData->email,
                        2 => $personData->first_name,
                        3 => $personData->last_name,
                        4 => $personData->gender_label,
                        5 => $personData->address,
                        6 => $personData->city,
                    ]);
                }
            );
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
            ->visit(new AdminPersonDataListPage)
            ->click('@crud-create-button')
            ->on(new AdminPersonDataAddPage);

        $this->waitForRequestsToFinish($browser);
    }

    /**
     * @param Browser $browser
     * @throws TimeoutException
     */
    protected function submit(Browser $browser)
    {
        $browser->click('@crud-form-submit-button');
        $this->waitForRequestsToFinish($browser);
    }
}
