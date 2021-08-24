<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Admin\Pages\AdminSponsorAddPage;
use Tests\Browser\Admin\Pages\AdminSponsorListPage;
use Throwable;

class AdminSponsorAddTest extends AdminTestCase
{
    /**
     * @throws Throwable
     */
    public function test_validates_required_fields()
    {
        $this->browse(function (Browser $b) {
            $this->goToPage($b);
            $this->disableHtmlFormValidation($b);
            $this->clickSubmitButton($b);
            $this->assertAllRequiredErrorsAreShown($b, [
                '@email-input-wrapper',
                '@first_name-input-wrapper',
                '@last_name-input-wrapper',
            ]);
            $this->assertAdminRadioHasRequiredError($b, 'gender');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_email_field()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $this->fillRequiredFields($browser);
            $browser->type('email', 'sdfdsfds');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost mora biti veljaven email naslov.');

            $this->goToPage($browser);
            $this->fillRequiredFields($browser);
            $browser->with('@gender-input-wrapper', function (Browser $browser) {
                $browser->click('input[type="radio"][value="1"]');
            });
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vnos uspešen.');
        });
    }

    /**
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
                        6 => '0 botrstev',
                        7 => '0 botrstev',
                    ]);
                }
            );
        });
    }

    /**
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

    protected function fillRequiredFields(Browser $b)
    {
        /** @var PersonData $personData */
        $personData = PersonData::factory()->makeOne();
        $b->type('email', $personData->email);
        $b->type('first_name', $personData->first_name);
        $b->type('last_name', $personData->last_name);
    }
}
