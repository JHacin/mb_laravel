<?php

namespace Tests\Browser\Admin;

use App\Models\PersonData;
use Facebook\WebDriver\Exception\TimeoutException;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminSponsorEditPage;
use Tests\Browser\Pages\Admin\AdminSponsorListPage;
use Throwable;

class AdminSponsorEditTest extends AdminTestCase
{
    /**
     * @var PersonData|null
     */
    protected static ?PersonData $testPersonData = null;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$testPersonData) {
            static::$testPersonData = $this->createPersonData();
        }
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_shows_person_data_details()
    {
        $this->browse(function (Browser $browser) {
            $personData = static::$testPersonData;
            $this->goToPage($browser);

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
                ->assertSelected('country', $personData->country);
        });
    }

    /**
     * @return void
     * @throws Throwable
     */
    public function test_validates_email()
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

            $existingPersonData = $this->createPersonData();
            $this->goToPage($browser);
            $browser->type('email', $existingPersonData->email);
            $this->submit($browser);
            $browser->assertSee('Ta email naslov je že v uporabi.');

            $this->goToPage($browser);
            $browser->type('email', $this->faker->unique()->safeEmail);
            $this->submit($browser);
            $browser->assertSee('Urejanje uspešno.');

            $this->goToPage($browser);
            $this->submit($browser);
            $browser->assertSee('Urejanje uspešno.');
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
            ->visit(new AdminSponsorEditPage(static::$testPersonData));

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
