<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use App\Models\User;
use Facebook\WebDriver\Exception\TimeOutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminUserAddPage;
use Tests\Browser\Pages\Admin\AdminUserListPage;
use Throwable;

class AdminUserAddTest extends AdminTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->markTestSkipped('skipping until user profiles are implemented for the public audience');
    }

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
                '@name-input-wrapper',
                '@email-input-wrapper',
                '@password-input-wrapper',
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
            $browser->type('email', 'sdfdsfds');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost mora biti veljaven email naslov.');

            $this->goToPage($browser);
            $browser->type('email', static::$sampleUser->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            $this->goToPage($browser);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->clickSubmitButton($browser);
            $browser->assertDontSee('Ta email naslov je že v uporabi.');
        });
    }

    /**
     * @throws Throwable
     */
    public function test_validates_password()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('password', 'a');
            $browser->type('password_confirmation', 'b');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Gesli se ne ujemata.');

            $this->goToPage($browser);
            $this->disableHtmlFormValidation($browser);
            $browser->type('password', 'a');
            $browser->type('password_confirmation', 'a');
            $this->clickSubmitButton($browser);
            $browser->assertDontSee('Gesli se ne ujemata.');
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

            $this->selectDatepickerDateInThePast($browser, '@date_of_birth-input-wrapper');

            $browser
                ->type('personData[address]', $personData->address)
                ->type('personData[zip_code]', $personData->zip_code)
                ->type('personData[city]', $personData->city)
                ->select('personData[country]', $personData->country);

            $this->clickCheckbox($browser, '@is_active-input-wrapper');
            $this->clickCheckbox($browser, '@should_send_welcome_email-input-wrapper');

            $this->clickSubmitButton($browser);
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
}
