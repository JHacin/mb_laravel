<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorListPage;
use Tests\Browser\Pages\Admin\AdminUserEditPage;
use Throwable;

class AdminSponsorEditTest extends AdminTestCase
{
    /**
     * @var PersonData|null
     */
    protected static ?PersonData $testAnonSponsor = null;

    /**
     * @var PersonData|null
     */
    protected static ?PersonData $testRegisteredSponsor = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$testAnonSponsor || !static::$testRegisteredSponsor) {
            static::$testAnonSponsor = $this->createPersonData();
            static::$testRegisteredSponsor = $this->createUserWithPersonData()->personData;
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_person_data_details()
    {
        $this->browse(function (Browser $browser) {
            $personData = static::$testAnonSponsor;
            $this->goToPage($browser, static::$testAnonSponsor);

            $browser
                ->assertValue('input[name="email"]', $personData->email)
                ->assertValue('input[name="first_name"]', $personData->first_name)
                ->assertValue('input[name="last_name"]', $personData->last_name)
                ->assertValue('input[name="gender"]', $personData->gender)
                ->assertValue('input[name="phone"]', $personData->phone)
                ->assertValue('input[name="date_of_birth"]', $personData->date_of_birth->toDateString())
                ->assertValue('input[name="address"]', $personData->address)
                ->assertValue('input[name="zip_code"]', $personData->zip_code)
                ->assertValue('input[name="city"]', $personData->city)
                ->assertSelected('country', $personData->country)
                ->assertValue('input[name="is_confirmed"', (int)$personData->is_confirmed);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email_format()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser, static::$testAnonSponsor);
            $this->disableHtmlFormValidation($browser);
            $browser->type('email', 'sdfdsfds');
            $this->clickSubmitButton($browser);
            $browser->assertSee('Vrednost mora biti veljaven email naslov.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_existing_user_unique_email()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser, static::$testAnonSponsor);
            $browser->type('email', static::$sampleUser->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_accepts_related_user_email_for_registered_sponsor()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser, static::$testRegisteredSponsor);
            $browser->type('email', static::$testRegisteredSponsor->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_existing_person_data_unique_email()
    {
        $this->browse(function (Browser $browser) {
            $existingPersonData = $this->createPersonData();
            $this->goToPage($browser, static::$testAnonSponsor);
            $browser->type('email', $existingPersonData->email);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_accepts_valid_email()
    {
        $this->browse(function (Browser $browser) {
            $this->goToPage($browser, static::$testAnonSponsor);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');

            $this->goToPage($browser, static::$testAnonSponsor);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_updates_related_user_email()
    {
        $this->browse(function (Browser $browser) {
            $newEmail = $this->faker->unique()->safeEmail;
            $this->goToPage($browser, static::$testRegisteredSponsor);
            $browser->type('email', $newEmail);
            $this->clickSubmitButton($browser);
            $browser->assertSee('Urejanje uspešno.');

            $this->assertDatabaseHas('users', [
                'id' => static::$testRegisteredSponsor->user_id,
                'email' => $newEmail
            ]);
            $this->assertDatabaseHas('person_data', [
                'id' => static::$testRegisteredSponsor->id,
                'email' => $newEmail
            ]);
            $browser
                ->visit(new AdminUserEditPage(static::$testRegisteredSponsor->user))
                ->assertValue('input[name="email"]', $newEmail);
        });
    }

    /**
     * @param Browser $browser
     * @param PersonData $sponsor
     * @throws TimeoutException
     */
    protected function goToPage(Browser $browser, PersonData $sponsor)
    {
        $browser
            ->loginAs(static::$defaultAdmin)
            ->visit(new AdminSponsorListPage)
            ->visit(new AdminSponsorEditPage($sponsor));

        $this->waitForRequestsToFinish($browser);
    }
}
