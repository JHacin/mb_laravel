<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorAddPage;
use Tests\Browser\Pages\Admin\AdminSponsorListPage;
use Throwable;

class AdminSponsorAddTest extends AdminTestCase
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
            $this->clickSubmitButton($browser);
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
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost mora biti veljaven email naslov.');

            $this->goToPage($browser);
            $browser->type('email', static::$sampleUser->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            /** @var PersonData $existingPersonData */
            $existingPersonData = PersonData::inRandomOrder()->first();
            $this->goToPage($browser);
            $browser->type('email', $existingPersonData->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            $this->goToPage($browser);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->clickSubmitButton($browser);
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
            $this->selectDatepickerDateInTheFuture($browser, '@date_of_birth-input-wrapper');
            $this->clickSubmitButton($browser);
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
                $browser->click('input[type="radio"][value="' . $personData->gender . '"]');
            });

            $this->selectDatepickerDateInThePast($browser, '@date_of_birth-input-wrapper');

            $browser
                ->type('address', $personData->address)
                ->type('zip_code', $personData->zip_code)
                ->type('city', $personData->city)
                ->select('country', $personData->country);

            $this->clickSubmitButton($browser);
            $browser->assertSee('Vnos uspešen.');
            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal',
                function (Browser $browser) use ($personData) {
                    $this->assertDetailsModalShowsValuesInOrder($browser, [
                        0 => $personData->id,
                        1 => $personData->email,
                        2 => $personData->first_name,
                        3 => $personData->last_name,
                        4 => $personData->city,
                        5 => $this->formatToDatetimeColumnString($personData->created_at),
                        6 => '0 botrovanj',
                        7 => '0 botrovanj',
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
            ->visit(new AdminSponsorListPage)
            ->click('@crud-create-button')
            ->on(new AdminSponsorAddPage);

        $this->waitForRequestsToFinish($browser);
    }
}
