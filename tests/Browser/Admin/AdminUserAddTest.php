<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use App\Models\User;
use Carbon\Carbon;
use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminCatListPage;
use Tests\Browser\Pages\Admin\AdminUserAddPage;
use Tests\Browser\Pages\Admin\AdminUserListPage;
use Throwable;

class AdminUserAddTest extends AdminTestCase
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
            $this->assertAllRequiredErrorsAreShown($browser, [
                '@name-input-wrapper',
                '@email-input-wrapper',
                '@password-input-wrapper',
            ]);
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

            $this->goToPage($browser);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->submit($browser);
            $browser->assertDontSee('Ta email naslov je že v uporabi.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_password()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('password', 'a');
            $browser->type('password_confirmation', 'b');
            $this->submit($browser);
            $browser->assertSee('Gesli se ne ujemata.');

            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('password', 'a');
            $browser->type('password_confirmation', 'a');
            $this->submit($browser);
            $browser->assertDontSee('Gesli se ne ujemata.');
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
    public function test_adding_a_user_works()
    {
        $this->browse(function (Browser $browser) {
            /** @var User $user */
            $user = User::factory()->makeOne();
            /** @var PersonData $personData */
            $personData = PersonData::factory()->makeOne();

            $this->goToPage($browser);

            $browser
                ->type('name', $user->name)
                ->type('email', $user->email)
                ->type('password', 'LoremIpsum1234')
                ->type('password_confirmation', 'LoremIpsum1234')
                ->click('input[type="checkbox"][value="3"]')
                ->type('personData[first_name]', $personData->first_name)
                ->type('personData[last_name]', $personData->last_name);

            $browser->with('@gender-input-wrapper', function (Browser $browser) {
                $browser->click('input[value="2"]');
            });

            $browser->type('personData[phone]', $personData->phone);

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
                ->type('personData[address]', $personData->address)
                ->type('personData[zip_code]', $personData->zip_code)
                ->type('personData[city]', $personData->city)
                ->select('personData[country]', $personData->country);

            $browser->with('@is_active-input-wrapper', function (Browser $browser) {
                $browser->click('input[data-init-function="bpFieldInitCheckbox"]');
            });

            $browser->with('@should_send_welcome_email-input-wrapper', function (Browser $browser) {
                $browser->click('input[data-init-function="bpFieldInitCheckbox"]');
            });

            $this->submit($browser);

            $browser->assertSee('Vnos uspešen.');

            $this->openFirstRowDetails($browser);
            $browser->whenAvailable('@data-table-row-details-modal',
                function (Browser $browser) use ($user, $personData) {
                    $this->assertDetailsModalShowsValuesInOrder($browser, [
                        1 => $user->name,
                        2 => $user->email,
                        3 => $personData->first_name,
                        4 => $personData->last_name,
                        5 => 'editor',
                        6 => 'Da',
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
            ->visit(new AdminUserListPage)
            ->click('@crud-create-button')
            ->on(new AdminUserAddPage);

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